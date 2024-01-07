<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Traits\ModelHelper;
use App\Models\Notification;
use App\Models\User;
use App\Traits\NotificationTrait;
use Illuminate\Support\Facades\Auth;

class NotificationService
{
    use ModelHelper, NotificationTrait;

    public function getAll($by_admin = 0)
    {
        if ($by_admin == 1) {
            return Notification::with('order')->where('by_admin', 1)->orderBy('created_at', 'desc')->get();
        } else {
            return User::where('id', Auth::user()->id)->with('notifications.order')->first();
        }
    }

    public function find($notificationId)
    {
        return $this->findByIdOrFail(Notification::class, 'notification', $notificationId);
    }

    public function create($validatedData)
    {

        $validatedData['by_admin'] = 1;

        $validatedData['title'] = [
            'en' => $validatedData['title_en'],
            'ar' => $validatedData['title_ar'],
        ];

        $validatedData['body'] = [
            'en' => $validatedData['details_en'],
            'ar' => $validatedData['details_ar'],
        ];

        $notification = Notification::create($validatedData);

        if ($validatedData['to_type'] == 'user') {
            $users = User::where('role', 'user')->where('status', 1)->get();
        } elseif ($validatedData['to_type'] == 'provider') {
            $users = User::where('role', 'provider')->where('status', 1)->where('accepted', 1)->get();
        } else {
            $users = User::where(function ($query) {
                $query->where('role', 'user')->where('status', 1);
            })->orWhere(function ($query) {
                $query->where('role', 'provider')->where('status', 1)->where('accepted', 1);
            })->get();
        }

        $notificationData = [
            'title' => ['en' => $validatedData['title_en'], 'ar'   => $validatedData['title_ar']],
            'body'  => ['en' => $validatedData['details_en'], 'ar' => $validatedData['details_ar']],
            'service_id'   => null,
            'service_type' => null
        ];

        foreach ($users as $user) {
            $user->notifications()->attach($notification);
            if ($user->enable_notification == 1) {

                if (isset($user->fcm_token)) {
                    $lang = $user->app_lang;
                    $data = [
                        'title' => $notificationData['title'][$lang],
                        'body'  => $notificationData['body'][$lang],
                        'service_id'   =>  $notificationData['service_id'],
                        'service_type' =>  $notificationData['service_type'],
                        'order_status' => null,
                    ];

                    $this->send_notification($user->fcm_token, $data);
                }
            }
        }


        return $notification;
    }

    public function update($validatedData, $notificationId)
    {
        $notification = $this->find($notificationId);

        DB::beginTransaction();

        $notification->update($validatedData);

        DB::commit();

        return true;
    }

    public function delete($notificationId)
    {
        $notification = $this->find($notificationId);

        DB::beginTransaction();

        DB::table('notification_user')->where('notification_id', '=',  $notificationId)->delete();

        $notification->delete();


        DB::commit();

        return true;
    }

    public function bulkDelete($checked)
    {
        $notifications = Notification::whereIn('id', $checked)->get();

        DB::beginTransaction();

        foreach ($notifications as $notification) {
            DB::table('notification_user')->where('notification_id', '=',  $notification->id)->delete();
            $notification->delete();
        }

        DB::commit();

        return true;
    }

    public function deleteForUser($notificationId)
    {
        $notification = $this->find($notificationId);

        DB::table('notification_user')->where('user_id', '=',  Auth::id())
            ->where('notification_id', '=',  $notificationId)->delete();

        return true;
    }

    public function deleteAllForUser()
    {
        DB::table('notification_user')->where('user_id', '=',  Auth::id())->delete();

        return true;
    }

    public function seeAll()
    {
        DB::table('notification_user')->where('user_id', '=',  Auth::id())->update(['seen' => 1, 'seen_at' => now()]);
    }

    public function unseenCount()
    {
        $user = User::where('id', Auth::id())->first();
        return $user->notifications()->where('seen', 0)->count();
    }
}

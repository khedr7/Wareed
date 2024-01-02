<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Traits\ModelHelper;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class NotificationService
{
    use ModelHelper;

    public function getAll($by_admin = 0)
    {
        if ($by_admin == 1) {
            return Notification::where('by_admin', 1)->orderBy('created_at', 'desc')->get();
        } else {
            $user = User::where('id', Auth::user()->id)->with('notifications')->first();
            return $user->notifications;
        }
    }

    public function find($notificationId)
    {
        return $this->findByIdOrFail(Notification::class, 'notification', $notificationId);
    }

    public function create($validatedData)
    {
        DB::beginTransaction();

        $notification = Notification::create($validatedData);

        DB::commit();

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

        $notification->delete();

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

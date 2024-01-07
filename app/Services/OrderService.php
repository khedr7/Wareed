<?php

namespace App\Services;

use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use App\Traits\ModelHelper;
use App\Traits\NotificationTrait;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    use ModelHelper, NotificationTrait;

    public function getAllDashboard()
    {
        $data = Order::with(['paymentMethod', 'user', 'provider', 'service'  => function ($query) {
            $query->withTrashed();
        }])->orderBy('created_at', 'desc')->get();
        return $data;
    }

    public function getAll()
    {

        if (request()->has('status')) {
            if (request()->has('provider_id')) {
                $user = User::findOrFail(request()->provider_id);
                $data =  Order::with(['user', 'provider', 'service', 'paymentMethod'])
                    ->where('status', request()->status)->where('provider_id', request()->provider_id)->get();

                return $data;
            }
            $user = Auth::user();
            $user = User::findOrFail($user->id);
            $data =  Order::with(['user', 'provider', 'service', 'paymentMethod'])
                ->where('status', request()->status)->where('user_id', $user->id)->get();

            return $data;
        } else {
            if (request()->has('provider_id')) {
                $user = User::findOrFail(request()->provider_id);
                $data = [
                    'Pending'   => Order::with(['user', 'provider', 'service', 'paymentMethod'])->where('status', 'Pending')->where('provider_id', request()->provider_id)->get(),
                    'Confirmed' => Order::with(['user', 'provider', 'service', 'paymentMethod'])->where('status', 'Confirmed')->where('provider_id', request()->provider_id)->get(),
                    'Cancelled' => Order::with(['user', 'provider', 'service', 'paymentMethod'])->where('status', 'Cancelled')->where('provider_id', request()->provider_id)->get(),
                ];
                return $data;
            }
            $user = Auth::user();
            $user = User::findOrFail($user->id);
            $data = [
                'Pending'   => Order::with(['user', 'provider', 'service', 'paymentMethod'])->where('status', 'Pending')->where('user_id', $user->id)->get(),
                'Confirmed' => Order::with(['user', 'provider', 'service', 'paymentMethod'])->where('status', 'Confirmed')->where('user_id', $user->id)->get(),
                'Cancelled' => Order::with(['user', 'provider', 'service', 'paymentMethod'])->where('status', 'Cancelled')->where('user_id', $user->id)->get(),
            ];
            return $data;
        }
    }


    public function calendar()
    {
        $user = Auth::user();
        $data = Order::with(['user', 'provider', 'service', 'paymentMethod'])
            ->where('provider_id', $user->id)->where('status', '!=', 'Cancelled')
            ->where(function ($query) {
                $query->whereYear('date', request('year'))
                    ->whereMonth('date', request('month'))
                    ->orWhere(function ($subquery) {
                        $subquery->whereYear('end_date', request('year'))
                            ->whereMonth('end_date', request('month'));
                    });
            })->get();
        return $data;
    }

    public function find($orderId)
    {
        return $this->findByIdOrFail(Order::class, 'order', $orderId);
    }

    public function create($validatedData)
    {
        DB::beginTransaction();
        $validatedData['user_id'] = Auth::user()->id;
        $validatedData['status']  = 'Pending';
        $order = Order::create($validatedData);

        if ($order) {
            $provider = $order->provider;
            $service = $order->service;

            $notificationData = [
                'title' => ['en' => 'New Order', 'ar' => 'طلب جديد'],
                'body' => [
                    'en' => 'A new Order has been created for service: ' . $service->getTranslation('name', 'en', false),
                    'ar' => 'تم انشاء طلب جديد للخدمة :  ' . $service->getTranslation('name', 'ar', false),
                ],
                'service_id' => $order->id,
                'service_type' => 'order'
            ];

            $notification = Notification::create($notificationData);
            $provider->notifications()->attach($notification);
            if (isset($provider->fcm_token) && $provider->enable_notification == 1) {
                $lang = $provider->app_lang;
                $data = [
                    'title' => $notificationData['title'][$lang],
                    'body' => $notificationData['body'][$lang],
                    'service_id' => $order->id,
                    'service_type' => 'order',
                    'order_status' => $order->status,
                ];

                $this->send_notification($provider->fcm_token, $data);
            }
        }

        DB::commit();

        return $order;
    }

    public function update($validatedData, $orderId)
    {
        $order = $this->find($orderId);

        DB::beginTransaction();

        $order->update($validatedData);

        DB::commit();

        return true;
    }

    public function delete($orderId)
    {
        $order = $this->find($orderId);

        DB::beginTransaction();

        $order->delete();

        DB::commit();

        return true;
    }

    public function paymentStatus($order_id)
    {
        $user = $this->find($order_id);

        DB::beginTransaction();

        if ($user->payment_status == 0) {
            $user->payment_status = 1;
            $user->save();
            $message = [
                'status'   => 'success',
                'message'  => 'payment_status changed to active !',
            ];
        } else {
            $user->payment_status = 0;
            $user->save();
            $message = [
                'status'   => 'delete',
                'message'  => 'payment_status changed to deactive !',
            ];
        }

        DB::commit();

        return $message;
    }

    public function status($validatedData, $order_id)
    {
        $order = $this->find($order_id);
        $auth = User::where('id', Auth::user()->id)->first();
        DB::beginTransaction();

        $updated = $order->update($validatedData);
        if ($updated) {
            $provider = $order->provider;
            $service  = $order->service;
            $user     = $order->user;
            if ($auth->role == 'admin') {

                $notificationData = [
                    'title' => ['en' => 'Change order status', 'ar' => 'تغيير حالة الطلب'],
                    'body' => [
                        'en' => 'The order status has been changed for service : ' . $service->getTranslation('name', 'en', false),
                        'ar' => 'تم تغيير حالة طلب الخدمة : ' . $service->getTranslation('name', 'ar', false),
                    ],
                    'service_id' => $order->id,
                    'service_type' => 'order'
                ];


                $notification = Notification::create($notificationData);

                $provider->notifications()->attach($notification);

                if (isset($provider->fcm_token) && $provider->enable_notification == 1) {
                    $lang = $provider->app_lang;
                    $data = [
                        'title' => $notificationData['title'][$lang],
                        'body' => $notificationData['body'][$lang],
                        'service_id' => $order->id,
                        'service_type' => 'order',
                        'order_status' => $order->status,

                    ];

                    $this->send_notification($provider->fcm_token, $data);
                }
            }

            if (isset($user->fcm_token) && $user->enable_notification == 1) {

                $notificationData = [
                    'title' => ['en' => 'Change order status', 'ar' => 'تغيير حالة الطلب'],
                    'body' => [
                        'en' => 'The order status has been changed for service : ' . $service->getTranslation('name', 'en', false),
                        'ar' => 'تم تغيير حالة طلب الخدمة : ' . $service->getTranslation('name', 'ar', false),
                    ],
                    'service_id' => $order->id,
                    'service_type' => 'booking'
                ];


                $user_notification = Notification::create($notificationData);
                $user->notifications()->attach($user_notification);

                $lang = $user->app_lang;
                $data = [
                    'title' => $notificationData['title'][$lang],
                    'body' => $notificationData['body'][$lang],
                    'service_id' => $order->id,
                    'service_type' => $notificationData['service_type'],
                    'order_status' => $order->status,
                ];

                $this->send_notification($user->fcm_token, $data);
            }
        }


        DB::commit();

        return true;
    }
    public function cancelOrder($order_id)
    {
        $order = $this->find($order_id);

        DB::beginTransaction();

        $updated = $order->update(
            [
                'status' => 'Cancelled',
            ]
        );

        if ($updated) {
            $provider = $order->provider;
            $service  = $order->service;
            $user     = $order->user;

            $notificationData = [
                'title' => ['en' => 'Cancell order', 'ar' => 'إلغاء الطلب'],
                'body' => [
                    'en' => $user->name . ' cancelled the order for service : ' . $service->getTranslation('name', 'en', false),
                    'ar' =>  $user->name .  ' ألغى طلب الخدمة : ' . $service->getTranslation('name', 'ar', false),
                ],
                'service_id' => $order->id,
                'service_type' => 'order'
            ];

            $notification = Notification::create($notificationData);
            $provider->notifications()->attach($notification);

            if (isset($provider->fcm_token) && $provider->enable_notification == 1) {
                $lang = $provider->app_lang;
                $data = [
                    'title' => $notificationData['title'][$lang],
                    'body' => $notificationData['body'][$lang],
                    'service_id' => $order->id,
                    'service_type' => 'order',
                    'order_status' => $order->status,
                ];

                $this->send_notification($provider->fcm_token, $data);
            }
        }

        DB::commit();

        return true;
    }
}

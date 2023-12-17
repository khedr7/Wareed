<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Traits\ModelHelper;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    use ModelHelper;

    public function getAllDashboard()
    {
        $data = Order::with(['paymentMethod','user', 'provider','service'  => function ($query) {
            $query->withTrashed();
        }])->get();
        return $data;
    }

    public function getAll()
    {

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

    public function calendar()
    {
        $user = Auth::user();
        $data = Order::with(['user', 'provider', 'service', 'paymentMethod'])
            ->where('provider_id', $user->id)
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
        $order = Order::create($validatedData);

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

        DB::beginTransaction();

        $order->update($validatedData);

        DB::commit();

        return true;
    }
    public function cancelOrder($order_id)
    {
        $order = $this->find($order_id);

        DB::beginTransaction();

        $order->update(
            [
                'status' => 'Cancelled',
            ]
        );

        DB::commit();

        return true;
    }
}

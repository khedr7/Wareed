<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Traits\ModelHelper;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    use ModelHelper;

    public function getAll()
    {
        if(request()->has('provider_id'))
        {
            return Order::with([
                'user:id,name',
                'paymentMethod:id,name'
            ])->whereHas('service', function ($query) {
                $query->where('user_id', request()->provider_id);
            })
            ->orderBy('id', 'desc')->app();
        }
        if(request()->routeIs('app.orders.getAll'))
        {
            return Order::where('user_id',Auth::user()->id)->with([
                'user:id,name',
                'service' => function ($query) {
                    $query->with('user:id,name')->select('id', 'name', 'user_id');
                },
                'paymentMethod:id,name'
            ])->orderBy('id', 'desc')->app();
        }
        return Order::with([
            'user:id,name',
            'service' => function ($query) {
                $query->with('user:id,name')->select('id', 'name', 'user_id');
            },
            'paymentMethod:id,name'
        ])->orderBy('id', 'desc')->app();
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
}

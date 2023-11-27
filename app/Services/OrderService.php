<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Traits\ModelHelper;
use App\Models\Order;

class OrderService
{
    use ModelHelper;

    public function getAll()
    {
        return Order::with([
            'user:id,name',
            'service' => function ($query) {
                $query->with('user:id,name')->select('id', 'name', 'user_id');
            },
            'paymentMethod:id,name'
        ])->orderBy('id', 'desc')->get();
    }

    public function find($orderId)
    {
        return $this->findByIdOrFail(Order::class, 'order', $orderId);
    }

    public function create($validatedData)
    {
        DB::beginTransaction();

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

<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Traits\ModelHelper;
use App\Models\PaymentMethod;

class PaymentMethodService
{
    use ModelHelper;

    public function getAll()
    {
        return PaymentMethod::all();
    }

    public function find($payment_methodId)
    {
        return $this->findByIdOrFail(PaymentMethod::class, 'paymentMethod', $payment_methodId);
    }

    public function create($validatedData)
    {
        DB::beginTransaction();

        $payment_method = PaymentMethod::create($validatedData);

        DB::commit();

        return $payment_method;
    }

    public function update($validatedData, $payment_methodId)
    {
        $payment_method = $this->find($payment_methodId);

        DB::beginTransaction();

        $payment_method->update($validatedData);

        DB::commit();

        return true;
    }

    public function delete($payment_methodId)
    {
        $payment_method = $this->find($payment_methodId);

        DB::beginTransaction();

        $payment_method->delete();

        DB::commit();

        return true;
    }

    public function status($payment_methodId)
    {
        $method = $this->find($payment_methodId);

        DB::beginTransaction();

        if ($method->status == 0) {
            $method->status = 1;
            $method->save();
            $message = [
                'status'   => 'success',
                'message'  => 'Status changed to active !',
            ];
        } else {
            $method->status = 0;
            $method->save();
            $message = [
                'status'   => 'delete',
                'message'  => 'Status changed to deactive !',
            ];
        }

        DB::commit();

        return $message;
    }
}

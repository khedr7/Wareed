<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentMethodRequest;
use App\Http\Resources\PaymentMethodResource;
use App\Services\PaymentMethodService;

class PaymentMethodController extends Controller
{
    public function __construct(private PaymentMethodService $payment_methodService)
    {
    }

    public function index()
    {
        $paymentMethods = $this->payment_methodService->getAll();

        return view('paymentMethods.index', compact("paymentMethods"));
    }

    public function find($payment_methodId)
    {
        $payment_method = $this->payment_methodService->find($payment_methodId);

        return $this->successResponse(
            $this->resource($payment_method, PaymentMethodResource::class),
            'dataFetchedSuccessfully'
        );
    }

    public function create(PaymentMethodRequest $request)
    {
        $validatedData = $request->validated();
        $payment_method = $this->payment_methodService->create($validatedData);

        return $this->successResponse(
            $this->resource($payment_method, PaymentMethodResource::class),
            'dataAddedSuccessfully'
        );
    }

    public function update(PaymentMethodRequest $request, $payment_methodId)
    {
        $validatedData = $request->validated();
        $this->payment_methodService->update($validatedData, $payment_methodId);

        return $this->successResponse(
            null,
            'dataUpdatedSuccessfully'
        );
    }

    public function delete($payment_methodId)
    {
        $this->payment_methodService->delete($payment_methodId);

        return $this->successResponse(
            null,
            'dataDeletedSuccessfully'
        );
    }

    public function status($id)
    {
        $message = $this->payment_methodService->status($id);

        return response()->json($message);
    }
}

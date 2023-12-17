<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService)
    {
    }

    public function getAll()
    {
        $orders = $this->orderService->getAll();
        $data = [
            'Pending'   => OrderResource::collection($orders['Pending']),
            'Confirmed' => OrderResource::collection($orders['Confirmed']),
            'Cancelled' => OrderResource::collection($orders['Cancelled']),
        ];
        return $this->successResponse(
          $data,
            'dataFetchedSuccessfully'
        );
    }

    public function find($orderId)
    {
        $order = $this->orderService->find($orderId);

        return $this->successResponse(
            $this->resource($order, OrderResource::class),
            'dataFetchedSuccessfully'
        );
    }

    public function create(OrderRequest $request)
    {
        $validatedData = $request->validated();
        $order = $this->orderService->create($validatedData);

        return $this->successResponse(
            $this->resource($order, OrderResource::class),
            'dataAddedSuccessfully'
        );
    }

    public function update(OrderRequest $request, $orderId)
    {
        $validatedData = $request->validated();
        $this->orderService->update($validatedData, $orderId);

        return $this->successResponse(
            null,
            'dataUpdatedSuccessfully'
        );
    }

    public function delete($orderId)
    {
        $this->orderService->delete($orderId);

        return $this->successResponse(
            null,
            'dataDeletedSuccessfully'
        );
    }

    public function paymentStatus($id)
    {
        $message = $this->orderService->paymentStatus($id);

        return $this->successResponse(
            null,
            'dataUpdatedSuccessfully'
        );
    }

    public function status(OrderRequest $request, $id)
    {
        $validatedData = $request->validated();

        $message = $this->orderService->status($validatedData, $id);

        return $this->successResponse(
            null,
            'dataUpdatedSuccessfully'
        );
    }
    public function cancelOrder( $id)
    {

        $message = $this->orderService->cancelOrder($id);

        return $this->successResponse(
            null,
            'dataUpdatedSuccessfully'
        );
    }
}

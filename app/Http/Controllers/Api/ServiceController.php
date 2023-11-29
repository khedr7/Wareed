<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Services\ServiceService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct(private ServiceService $serviceService)
    {
    }

    public function getAll(Request $request)
    {
        $servvices = $this->serviceService->getAll($request);

        return $this->successResponse(
            $this->resource($servvices, ServiceResource::class),
            'dataFetchedSuccessfully'
        );
    }

    public function find($serviceId)
    {
        $service = $this->serviceService->find($serviceId);

        return $this->successResponse(
            $this->resource($service, ServiceResource::class),
            'dataFetchedSuccessfully'
        );
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StateResource;
use App\Services\StateService;

class StateController extends Controller
{
    public function __construct(private StateService $stateService)
    {
    }

    public function getAll()
    {
        $states = $this->stateService->getAllApp();

        return $this->successResponse(
            $this->resource($states, StateResource::class),
            'dataFetchedSuccessfully'
        );
    }

    public function find($stateId)
    {
        $state = $this->stateService->find($stateId);

        return $this->successResponse(
            $this->resource($state, StateResource::class),
            'dataFetchedSuccessfully'
        );
    }
}

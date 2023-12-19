<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequestRequest;
use App\Http\Resources\ServiceRequestResource;
use App\Services\ServiceRequestService;
use Illuminate\Http\Request;
use Validator;

class ServiceRequestController extends Controller
{
    public function __construct(private ServiceRequestService $service_requestService)
    {
    }

    public function index()
    {
        $requests = $this->service_requestService->getAll();

        return view('servicesRequests.index', compact("requests"));
    }

    public function find($service_requestId)
    {
        $service_request = $this->service_requestService->find($service_requestId);

        return $this->successResponse(
            $this->resource($service_request, ServiceRequestResource::class),
            'dataFetchedSuccessfully'
        );
    }

    public function create(ServiceRequestRequest $request)
    {
        $validatedData = $request->validated();
        $service_request = $this->service_requestService->create($validatedData);

        return $this->successResponse(
            $this->resource($service_request, ServiceRequestResource::class),
            'dataAddedSuccessfully'
        );
    }

    public function update(ServiceRequestRequest $request, $service_requestId)
    {
        $validatedData = $request->validated();
        $this->service_requestService->update($validatedData, $service_requestId);

        return $this->successResponse(
            null,
            'dataUpdatedSuccessfully'
        );
    }

    public function delete($service_requestId)
    {
        $this->service_requestService->delete($service_requestId);

        return back()->with('success', __('messages.dataDeletedSuccessfully'));
    }

    public function bulkDelete(Request $request)
    {
        $validator = Validator::make($request->all(), ['checked' => 'required']);

        if ($validator->fails()) {
            return back()->with('error',  __('messages.Please select field to be deleted.'));
        }

        $this->service_requestService->bulkDelete($request->checked);


        return back()->with('success',  __('messages.dataDeletedSuccessfully'));
    }
}

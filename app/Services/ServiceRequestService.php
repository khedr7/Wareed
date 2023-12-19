<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Traits\ModelHelper;
use App\Models\ServiceRequest;

class ServiceRequestService
{
    use ModelHelper;

    public function getAll()
    {
        return ServiceRequest::with('user:id,name')->get();
    }

    public function find($service_requestId)
    {
        return $this->findOrFail($service_requestId);
    }

    public function create($validatedData)
    {
        DB::beginTransaction();

        $service_request = ServiceRequest::create($validatedData);

        DB::commit();

        return $service_request;
    }

    public function update($validatedData, $service_requestId)
    {
        $service_request = $this->findOrFail($service_requestId);

        DB::beginTransaction();

        $service_request->update($validatedData);

        DB::commit();

        return true;
    }

    public function delete($service_requestId)
    {
        $service_request = ServiceRequest::where('id', $service_requestId)->first();

        DB::beginTransaction();

        $service_request->delete();

        DB::commit();

        return true;
    }

    public function bulkDelete($checked)
    {
        $service_requests = ServiceRequest::whereIn('id', $checked)->get();

        DB::beginTransaction();

        foreach ($service_requests as $service_request) {
            $service_request->delete();
        }

        DB::commit();

        return true;
    }
}

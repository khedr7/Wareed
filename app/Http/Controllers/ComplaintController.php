<?php

namespace App\Http\Controllers;

use App\Http\Requests\ComplaintRequest;
use App\Http\Resources\ComplaintResource;
use App\Services\ComplaintService;

class ComplaintController extends Controller
{
    public function __construct(private ComplaintService $complaintService)
    {
    }

    public function index()
    {
        $complaints = $this->complaintService->getAll();

        return view('complaints.index', compact("complaints"));

    }

    public function show($complaintId)
    {
        $complaint = $this->complaintService->show($complaintId);
        return response()->json(['complaint' => $complaint]);
    }

    public function create(ComplaintRequest $request)
    {
        $validatedData = $request->validated();
        $complaint = $this->complaintService->create($validatedData);

        return $this->successResponse(
            $this->resource($complaint, ComplaintResource::class),
            'dataAddedSuccessfully'
        );
    }

    public function update(ComplaintRequest $request, $complaintId)
    {
        $validatedData = $request->validated();
        $this->complaintService->update($validatedData, $complaintId);

        return $this->successResponse(
            null,
            'dataUpdatedSuccessfully'
        );
    }

    public function delete($complaintId)
    {
        $this->complaintService->delete($complaintId);

        return $this->successResponse(
            null,
            'dataDeletedSuccessfully'
        );
    }
}

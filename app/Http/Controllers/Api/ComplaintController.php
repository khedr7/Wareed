<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ComplaintReplyRequest;
use App\Http\Requests\ComplaintRequest;
use App\Http\Resources\ComplaintReplyResource;
use App\Http\Resources\ComplaintResource;
use App\Services\ComplaintReplyService;
use App\Services\ComplaintService;


class ComplaintController extends Controller
{
    public function __construct(
        private ComplaintService $complaintService,
        private ComplaintReplyService $complaint_replyService
    ) {
    }

    public function getAll()
    {
        $complaints = $this->complaintService->usersComplaint();
        return $this->successResponse(
            $this->resource($complaints, ComplaintResource::class),
            'dataFetchedSuccessfully'
        );
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

    public function reply(ComplaintReplyRequest $request)
    {
        $validatedData = $request->validated();
        $complaint = $this->complaint_replyService->create($validatedData);

        return $this->successResponse(
            $this->resource($complaint, ComplaintReplyResource::class),
            'dataAddedSuccessfully'
        );
    }
}

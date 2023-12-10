<?php

namespace App\Http\Controllers;

use App\Http\Requests\ComplaintReplyRequest;
use App\Http\Resources\ComplaintReplyResource;
use App\Services\ComplaintReplyService;

class ComplaintReplyController extends Controller
{
    public function __construct(private ComplaintReplyService $complaint_replyService)
    {
    }

    public function getAll()
    {
        $complaint_replies = $this->complaint_replyService->getAll();
        return $this->successResponse(
            $this->resource($complaint_replies, ComplaintReplyResource::class),
            'dataFetchedSuccessfully'
        );
    }

    public function find($complaint_replyId)
    {
        $complaint_reply = $this->complaint_replyService->find($complaint_replyId);

        return $this->successResponse(
            $this->resource($complaint_reply, ComplaintReplyResource::class),
            'dataFetchedSuccessfully'
        );
    }

    public function store(ComplaintReplyRequest $request)
    {
        $validatedData = $request->validated();
        $complaint_reply = $this->complaint_replyService->create($validatedData);

        return $complaint_reply;
    }

    public function update(ComplaintReplyRequest $request, $complaint_replyId)
    {
        $validatedData = $request->validated();
        $this->complaint_replyService->update($validatedData, $complaint_replyId);

        return $this->successResponse(
            null,
            'dataUpdatedSuccessfully'
        );
    }

    public function delete($complaint_replyId)
    {
        $this->complaint_replyService->delete($complaint_replyId);

        return $this->successResponse(
            null,
            'dataDeletedSuccessfully'
        );
    }
}

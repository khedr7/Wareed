<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Traits\ModelHelper;
use App\Models\ComplaintReply;

class ComplaintReplyService
{
    use ModelHelper;

    public function getAll()
    {
        return ComplaintReply::all();
    }

    public function find($complaint_replyId)
    {
        return $this->findOrFail($complaint_replyId);
    }

    public function create($validatedData)
    {
        DB::beginTransaction();

        $validatedData['user_id'] = auth()->user()->id;
        $complaint_reply = ComplaintReply::create($validatedData);

        DB::commit();

        return $complaint_reply;
    }

    public function update($validatedData, $complaint_replyId)
    {
        $complaint_reply = $this->findOrFail($complaint_replyId);

        DB::beginTransaction();

        $complaint_reply->update($validatedData);

        DB::commit();

        return true;
    }

    public function delete($complaint_replyId)
    {
        $complaint_reply = $this->find($complaint_replyId);

        DB::beginTransaction();

        $complaint_reply->delete();

        DB::commit();

        return true;
    }
}

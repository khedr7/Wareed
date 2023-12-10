<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Traits\ModelHelper;
use App\Models\Complaint;

class ComplaintService
{
    use ModelHelper;

    public function getAll()
    {
        return Complaint::with('user')->orderBy('id', 'desc')->get();
    }

    public function show($complaintId)
    {
        return Complaint::with(['user:id,name', 'replies.user:id,name'])->where('id', $complaintId)->first();
    }

    public function find($complaintId)
    {
        return $this->findByIdOrFail(Complaint::class, 'complaint', $complaintId);
    }

    public function create($validatedData)
    {
        DB::beginTransaction();

        $complaint = Complaint::create($validatedData);

        DB::commit();

        return $complaint;
    }

    public function update($validatedData, $complaintId)
    {
        $complaint = $this->findOrFail($complaintId);

        DB::beginTransaction();

        $complaint->update($validatedData);

        DB::commit();

        return true;
    }

    public function delete($complaintId)
    {
        $complaint = $this->find($complaintId);

        DB::beginTransaction();

        $complaint->delete();

        DB::commit();

        return true;
    }
}

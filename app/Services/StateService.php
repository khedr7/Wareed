<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Traits\ModelHelper;
use App\Models\State;

class StateService
{
    use ModelHelper;

    public function getAll()
    {
        return State::orderBy('id', 'desc')->get();
    }

    public function getCities($stateId)
    {
        return State::where('id', $stateId)->with(['cities' => function ($query) {
            $query->orderBy('id', 'desc');
        },])->first();
    }

    public function find($stateId)
    {
        return $this->findByIdOrFail(State::class, 'state', $stateId);
    }

    public function store($validatedData)
    {
        DB::beginTransaction();

        $validatedData['name'] = [
            'en' => $validatedData['name_en'],
            'ar' => $validatedData['name_ar'],
        ];

        $state = State::create($validatedData);

        DB::commit();

        return $state;
    }

    public function update($validatedData, $stateId)
    {
        $state = $this->findByIdOrFail(State::class, 'state', $stateId);

        DB::beginTransaction();

        $validatedData['name'] = [
            'en' => $validatedData['name_en'],
            'ar' => $validatedData['name_ar'],
        ];

        $state->update($validatedData);

        DB::commit();

        return $state;

        return true;
    }

    public function delete($stateId)
    {
        $state = $this->find($stateId);

        DB::beginTransaction();

        $state->cities()->delete();
        $state->delete();

        DB::commit();

        return true;
    }
}

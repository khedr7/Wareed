<?php

namespace App\Http\Controllers;

use App\Http\Requests\StateRequest;
use App\Http\Resources\StateResource;
use App\Services\StateService;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function __construct(private StateService $stateService)
    {
    }

    public function index(Request $request)
    {
        $states = $this->stateService->getAll();

        return view('states.index', compact("states"));
    }

    public function getCities($stateId)
    {
        $state = $this->stateService->getCities($stateId);

        return view('cities.index', compact("state"));
    }


    public function find($stateId)
    {
        $state = $this->stateService->find($stateId);

        return $this->successResponse(
            $this->resource($state, StateResource::class),
            'dataFetchedSuccessfully'
        );
    }


    public function store(StateRequest $request)
    {
        $validatedData = $request->validated();

        $this->stateService->store($validatedData);

        return redirect('states')->with('success', __('messages.dataAddedSuccessfully'));
    }

    public function update(StateRequest $request, $stateId)
    {
        $validatedData = $request->validated();

        $this->stateService->update($validatedData, $stateId);

        return redirect('states')->with('success', __('messages.dataUpdatedSuccessfully'));
    }

    public function delete($stateId)
    {
        $this->stateService->delete($stateId);

        return redirect('states')->with('success', __('messages.dataDeletedSuccessfully'));
    }
}

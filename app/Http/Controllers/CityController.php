<?php

namespace App\Http\Controllers;

use App\Http\Requests\CityRequest;
use App\Http\Resources\CityResource;
use Validator;
use App\Services\CityService;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function __construct(private CityService $cityService)
    {
    }

    public function getAll()
    {
        $cities = $this->cityService->getAll();
        return $this->successResponse(
            $this->resource($cities, CityResource::class),
            'dataFetchedSuccessfully'
        );
    }



    public function find($cityId)
    {
        $city = $this->cityService->find($cityId);

        return $this->successResponse(
            $this->resource($city, CityResource::class),
            'dataFetchedSuccessfully'
        );
    }

    public function create($stateId)
    {

        return view('cities.create', compact("stateId"));
    }

    public function store(CityRequest $request)
    {
        $validatedData = $request->validated();

        $this->cityService->store($validatedData);

        // return redirect('cities')->with('success', __('messages.dataAddedSuccessfully'));
        return redirect('states/' . $validatedData['state_id'] . '/cities')->with('success', __('messages.dataAddedSuccessfully'));
    }

    public function update(CityRequest $request, $cityId)
    {
        $validatedData = $request->validated();
        $this->cityService->update($validatedData, $cityId);

        return $this->successResponse(
            null,
            'dataUpdatedSuccessfully'
        );
    }

    public function delete($cityId)
    {
        $this->cityService->delete($cityId);

        return $this->successResponse(
            null,
            'dataDeletedSuccessfully'
        );
    }

    public function bulkDelete(Request $request)
    {
        $validator = Validator::make($request->all(), ['checked' => 'required']);

        if ($validator->fails()) {
            return back()->with('error',  __('messages.Please select field to be deleted.'));
        }

        $this->cityService->bulkDelete($request->checked);


        return back()->with('success',  __('messages.Selected Announcement has been deleted.'));
    }

}

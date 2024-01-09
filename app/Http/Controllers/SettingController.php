<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingRequest;
use App\Http\Resources\SettingResource;
use App\Services\SettingService;

class SettingController extends Controller
{
    public function __construct(private SettingService $settingService)
    {
    }

    public function index()
    {
        $settings = $this->settingService->getAll();
        return $this->successResponse(
            $this->resource($settings, SettingResource::class),
            'dataFetchedSuccessfully'
        );
    }

    public function find()
    {
        $setting = $this->settingService->find();

        return view('settings.edit', compact('setting'));
    }

    public function create(SettingRequest $request)
    {
        $validatedData = $request->validated();
        $setting = $this->settingService->create($validatedData);

        return $this->successResponse(
            $this->resource($setting, SettingResource::class),
            'dataAddedSuccessfully'
        );
    }

    public function update(SettingRequest $request)
    {
        $validatedData = $request->validated();
        $this->settingService->update($validatedData);

        return redirect('settings')->with('success', __('messages.dataUpdatedSuccessfully'));
    }

    public function delete($settingId)
    {
        $this->settingService->delete($settingId);

        return $this->successResponse(
            null,
            'dataDeletedSuccessfully'
        );
    }
}

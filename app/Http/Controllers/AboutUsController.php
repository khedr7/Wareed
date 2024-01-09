<?php

namespace App\Http\Controllers;

use App\Http\Requests\AboutUsRequest;
use App\Http\Resources\AboutUsResource;
use App\Services\AboutUsService;

class AboutUsController extends Controller
{
    public function __construct(private AboutUsService $aboutUs_Service)
    {
    }

    public function getAll()
    {
        $about_uses = $this->aboutUs_Service->getAll();
        return $this->successResponse(
            $this->resource($about_uses, AboutUsResource::class),
            'dataFetchedSuccessfully'
        );
    }

    public function find()
    {
        $about = $this->aboutUs_Service->find();

        return view('about.edit', compact('about'));
    }

    public function create(AboutUsRequest $request)
    {
        $validatedData = $request->validated();
        $about_u = $this->aboutUs_Service->create($validatedData);

        return $this->successResponse(
            $this->resource($about_u, AboutUsResource::class),
            'dataAddedSuccessfully'
        );
    }

    public function update(AboutUsRequest $request)
    {
        $validatedData = $request->validated();
        $this->aboutUs_Service->update($validatedData);

        return redirect('about-us')->with('success', __('messages.dataUpdatedSuccessfully'));
    }

    public function delete($about_uId)
    {
        $this->aboutUs_Service->delete($about_uId);

        return $this->successResponse(
            null,
            'dataDeletedSuccessfully'
        );
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\BannerRequest;
use App\Http\Resources\BannerResource;
use App\Services\BannerService;
use Validator;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function __construct(private BannerService $bannerService)
    {
    }

    public function index()
    {
        $banners = $this->bannerService->getAll();

        return view('banners.index', compact("banners"));
    }

    public function find($bannerId)
    {
        $banner = $this->bannerService->find($bannerId);

        return $this->successResponse(
            $this->resource($banner, BannerResource::class),
            'dataFetchedSuccessfully'
        );
    }

    public function store(BannerRequest $request)
    {
        $validatedData = $request->validated();

        $banner = $this->bannerService->store($validatedData);
        if ($request->file('image') && $request->file('image')->isValid()) {
            $banner->addMedia($request->image)->toMediaCollection('image');
        }

        return redirect('banners')->with('success', __('messages.dataAddedSuccessfully'));
    }

    public function update(BannerRequest $request, $bannerId)
    {
        $validatedData = $request->validated();
        $banner = $this->bannerService->update($validatedData, $bannerId);

        if ($request->file('image') && $request->file('image')->isValid()) {
            $banner->clearMediaCollection('image');
            $banner->addMedia($request->image)->toMediaCollection('image');
        }

        return redirect('banners')->with('success', __('messages.dataUpdatedSuccessfully'));
    }

    public function delete($bannerId)
    {
        $this->bannerService->delete($bannerId);

        return redirect('banners')->with('success', __('messages.dataDeletedSuccessfully'));
    }

    public function status($id)
    {
        $message = $this->bannerService->status($id);

        return response()->json($message);
    }

    public function bulkDelete(Request $request)
    {
        $validator = Validator::make($request->all(), ['checked' => 'required']);

        if ($validator->fails()) {
            return back()->with('error',  __('messages.Please select field to be deleted.'));
        }

        $this->bannerService->bulkDelete($request->checked);


        return back()->with('success',  __('messages.dataAddedSuccessfully'));
    }
}

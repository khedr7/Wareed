<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequest;
use App\Http\Resources\ServiceResource;
use Validator;
use App\Services\ServiceService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct(private ServiceService $serviceService)
    {
    }

    public function index(Request $request)
    {
        $services = $this->serviceService->getAll();

        return view('services.index', compact("services"));
    }

    public function find($serviceId)
    {
        $service = $this->serviceService->find($serviceId);

        return $this->successResponse(
            $this->resource($service, ServiceResource::class),
            'dataFetchedSuccessfully'
        );
    }

    public function create()
    {
        $data = $this->serviceService->create();
        $categories = $data['categories'];
        $users = $data['users'];

        return view('services.create', compact("categories", 'users'));
    }

    public function edit($id)
    {
        $data = $this->serviceService->edit($id);
        $categories = $data['categories'];
        $service = $data['service'];
        $users  = $data['users'];

        return view('services.edit', compact("categories", 'users', 'service'));
    }

    public function store(ServiceRequest $request)
    {
        $validatedData = $request->validated();
        $service = $this->serviceService->store($validatedData);

        if ($request->file('image') && $request->file('image')->isValid()) {
            $service->addMedia($request->image)->toMediaCollection('image');
        }

        return redirect('services')->with('success', __('messages.dataAddedSuccessfully'));
    }


    public function update(ServiceRequest $request, $serviceId)
    {
        $validatedData = $request->validated();

        $service = $this->serviceService->update($validatedData, $serviceId);

        if ($request->file('image') && $request->file('image')->isValid()) {
            $service->clearMediaCollection('image');
            $service->addMedia($request->image)->toMediaCollection('image');
        }

        return redirect('services')->with('success', __('messages.dataUpdatedSuccessfully'));
    }

    public function status($id)
    {
        $message = $this->serviceService->status($id);

        return response()->json($message);
    }

    public function delete($serviceId)
    {
        $this->serviceService->delete($serviceId);

        return redirect('services')->with('success', __('messages.dataDeletedSuccessfully'));
    }

    public function bulkDelete(Request $request)
    {
        $validator = Validator::make($request->all(), ['checked' => 'required']);

        if ($validator->fails()) {
            return back()->with('error',  __('messages.Please select field to be deleted.'));
        }

        $this->serviceService->bulkDelete($request->checked);


        return back()->with('success',  __('messages.dataAddedSuccessfully'));
    }
}

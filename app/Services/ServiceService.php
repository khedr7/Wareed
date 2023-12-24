<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\DB;
use App\Traits\ModelHelper;
use App\Models\Service;
use App\Models\ServiceRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ServiceService
{
    use ModelHelper;

    public function getAll($request)
    {
        return Service::with(['users', 'category:id,name'])->orderBy('id', 'desc')->app();
    }

    public function getTopRated()
    {
        return Service::with(['users', 'category:id,name'])->where('status', 1)->where('Featured', 1)->orderBy('id', 'desc')->get();
    }

    public function find($serviceId)
    {
        return $this->findByIdOrFail(Service::class, 'service', $serviceId);
    }

    public function create()
    {
        $data = [
            'categories' => Category::orderBy('name')->get(),
            'users'      => User::Where('role', 'provider')->orderBy('name')->get()
        ];

        return $data;
    }

    public function edit($id)
    {
        $data = [
            'service'    => $this->find($id),
            'categories' => Category::orderBy('name')->get(),
            'users'      => User::Where('role', 'provider')->orderBy('name')->get()
        ];
        return $data;
    }

    public function store($validatedData)
    {
        DB::beginTransaction();

        $validatedData['name'] = [
            'en' => $validatedData['name_en'],
            'ar' => $validatedData['name_ar'],
        ];

        $validatedData['details'] = [
            'en' => $validatedData['details_en'],
            'ar' => $validatedData['details_en'],
        ];

        $service = Service::create($validatedData);
        if (isset($validatedData['keys'])) {
            foreach ($validatedData['keys'] as $key) {
                $service->keywords()->create(['key' => $key]);
            }
        }

        DB::commit();

        return $service;
    }

    public function update($validatedData, $serviceId)
    {
        $service = $this->find($serviceId);

        DB::beginTransaction();

        $validatedData['name'] = [
            'en' => $validatedData['name_en'],
            'ar' => $validatedData['name_ar'],
        ];

        $validatedData['details'] = [
            'en' => $validatedData['details_en'],
            'ar' => $validatedData['details_en'],
        ];

        $service->update($validatedData);
        $service->keywords()->delete();
        if (isset($validatedData['keys'])) {
            foreach ($validatedData['keys'] as $key) {
                $service->keywords()->create(['key' => $key]);
            }
        }

        DB::commit();

        return $service;
    }

    public function delete($serviceId)
    {
        $service = $this->find($serviceId);

        DB::beginTransaction();

        $service->clearMediaCollection('image');
        $service->delete();

        DB::commit();

        return true;
    }

    public function bulkDelete($checked)
    {
        $services = Service::whereIn('id', $checked)->get();

        DB::beginTransaction();

        foreach ($services as $service) {
            $service->clearMediaCollection('image');
            $service->delete();
        }

        DB::commit();

        return true;
    }

    public function status($serviceId)
    {
        $service = $this->find($serviceId);

        DB::beginTransaction();

        if ($service->status == 0) {
            $service->status = 1;
            $service->save();
            $message = [
                'status'   => 'success',
                'message'  => 'Status changed to active !',
            ];
        } else {
            $service->status = 0;
            $service->save();
            $message = [
                'status'   => 'delete',
                'message'  => 'Status changed to deactive !',
            ];
        }

        DB::commit();

        return $message;
    }

    public function changeProviderServices($validatedData)
    {
        $provider = User::where('id', Auth::user()->id)->first();
        foreach($validatedData['services'] as $service){
            $this->addProviderServices($service);
        }
        // $provider->services()->sync($validatedData['services']);
    }

    public function addProviderServices($validatedData)
    {
        $provider = User::where('id', Auth::user()->id)->first();

        $pivotRow = DB::table('service_user')
            ->where('user_id', $provider->id)
            ->where('service_id', $validatedData['service_id'])
            ->delete();

        if ($validatedData['on_patient_site'] == 0 && $validatedData['on_patient_site'] == 0)
            return true;

        $provider->services()->attach($validatedData['service_id'], $validatedData);
        return true;
    }

    public function removeProviderServices($validatedData)
    {
        $provider = User::where('id', Auth::user()->id)->first();

        $pivotRow = DB::table('service_user')
            ->where('user_id', $provider->id)
            ->where('service_id', $validatedData['service_id'])
            ->delete();
    }

    public function orderService($validatedData)
    {
        DB::beginTransaction();

        $validatedData['user_id'] = Auth::user()->id;
        $serviceRequest = ServiceRequest::create($validatedData);

        DB::commit();

        return $serviceRequest;
    }
}

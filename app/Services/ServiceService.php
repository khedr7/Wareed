<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\DB;
use App\Traits\ModelHelper;
use App\Models\Service;
use App\Models\User;

class ServiceService
{
    use ModelHelper;

    public function getAll($request)
    {
        return Service::with(['user', 'category:id,name'])->orderBy('id', 'desc')->get();
    }

    public function getTopRated()
    {
        return Service::with(['user', 'category:id,name'])->orderBy('id', 'desc')->get()->take(5);
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

        $service = Service::create($validatedData);

        DB::commit();

        return $service;
    }

    public function update($validatedData, $serviceId)
    {
        $service = $this->find($serviceId);

        DB::beginTransaction();

        $service->update($validatedData);

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
}

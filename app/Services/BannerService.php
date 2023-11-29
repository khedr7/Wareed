<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Traits\ModelHelper;
use App\Models\Banner;

class BannerService
{
    use ModelHelper;

    public function getAll()
    {
        return Banner::all();
    }

    public function getAllActive()
    {
        return Banner::where(function ($query) {
            $query->where('start_date', '<=', now())
                ->where('expiration_date', '>=', now());
        })
            ->orWhere('expiration_date', null)
            ->get();
    }

    public function find($bannerId)
    {
        return $this->findByIdOrFail(Banner::class, 'banner', $bannerId);
    }

    public function store($validatedData)
    {
        DB::beginTransaction();

        $banner = Banner::create($validatedData);

        DB::commit();

        return $banner;
    }

    public function update($validatedData, $bannerId)
    {
        $banner = $this->find($bannerId);

        DB::beginTransaction();

        $banner->update($validatedData);

        DB::commit();

        return $banner;
    }

    public function delete($bannerId)
    {
        $banner = $this->find($bannerId);

        DB::beginTransaction();

        $banner->clearMediaCollection('image');
        $banner->delete();

        DB::commit();

        return true;
    }

    public function bulkDelete($checked)
    {
        $banners = Banner::whereIn('id', $checked)->get();

        DB::beginTransaction();

        foreach ($banners as $banner) {
            $banner->clearMediaCollection('image');
            $banner->delete();
        }

        DB::commit();

        return true;
    }

    public function status($bannerId)
    {
        $banner = $this->find($bannerId);

        DB::beginTransaction();

        if ($banner->status == 0) {
            $banner->status = 1;
            $banner->save();
            $message = [
                'status'   => 'success',
                'message'  => 'Status changed to active !',
            ];
        } else {
            $banner->status = 0;
            $banner->save();
            $message = [
                'status'   => 'delete',
                'message'  => 'Status changed to deactive !',
            ];
        }

        DB::commit();

        return $message;
    }
}

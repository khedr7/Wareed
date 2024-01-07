<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Traits\ModelHelper;
use App\Models\AboutU;
use App\Models\AboutUs;

class AboutUsService
{
    use ModelHelper;

    public function getAll()
    {
        return AboutUs::all();
    }

    public function find()
    {
        return AboutUs::first();
    }

    public function create($validatedData)
    {
        DB::beginTransaction();

        $about_u = AboutUs::create($validatedData);

        DB::commit();

        return $about_u;
    }

    public function update($validatedData)
    {
        $about_us =  AboutUs::first();

        DB::beginTransaction();

        $validatedData['details'] = [
            'en' => $validatedData['details_en'],
            'ar' => $validatedData['details_ar'],
        ];
        if ($about_us) {
            $about_us->update($validatedData);
        } else {
            $about_us = AboutUs::create($validatedData);
        }

        DB::commit();

        return true;
    }

    public function delete($about_uId)
    {
        $about_u = $this->find($about_uId);

        DB::beginTransaction();

        $about_u->delete();

        DB::commit();

        return true;
    }
}

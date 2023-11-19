<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Traits\ModelHelper;
use App\Models\City;

class CityService
{
    use ModelHelper;

    public function getAll()
    {
        return City::all();
    }

    public function find($cityId)
    {
        return $this->findByIdOrFail(City::class, 'city', $cityId);
    }

    public function store($validatedData)
    {
        DB::beginTransaction();

        for ($i = 0; $i < count($validatedData['name_en']); $i++) {
            $name = [
                'en' => $validatedData['name_en'][$i],
                'ar' => $validatedData['name_ar'][$i],
            ];
            $city = City::create([
                'name' => $name,
                'state_id' => $validatedData['state_id'],
            ]);
        }

        DB::commit();

        return true;
    }

    public function update($validatedData, $cityId)
    {
        $city = $this->findOrFail($cityId);

        DB::beginTransaction();

        $city->update($validatedData);

        DB::commit();

        return true;
    }

    public function delete($cityId)
    {
        $city = $this->find($cityId);

        DB::beginTransaction();

        $city->delete();

        DB::commit();

        return true;
    }

    public function bulkDelete($checked)
    {
        $cities = City::whereIn('id', $checked)->get();

        DB::beginTransaction();

        foreach ($cities as $city) {
            $city->delete();
        }

        DB::commit();

        return true;
    }
}

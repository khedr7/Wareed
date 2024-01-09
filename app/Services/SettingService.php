<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Traits\ModelHelper;
use App\Models\Setting;

class SettingService
{
    use ModelHelper;

    public function getAll()
    {
        return Setting::all();
    }

    public function find()
    {
        return Setting::first();
    }

    public function create($validatedData)
    {
        DB::beginTransaction();

        $setting = Setting::create($validatedData);

        DB::commit();

        return $setting;
    }

    public function update($validatedData)
    {
        $setting = Setting::first();

        DB::beginTransaction();
        if ($setting) {
            $setting->update($validatedData);
        } else {
            $setting = Setting::create($validatedData);
        }

        DB::commit();
        return true;
    }

    public function delete($settingId)
    {
        $setting = $this->find($settingId);

        DB::beginTransaction();

        $setting->delete();

        DB::commit();

        return true;
    }
}

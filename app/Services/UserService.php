<?php

namespace App\Services;

use App\Models\City;
use Illuminate\Support\Facades\DB;
use App\Traits\ModelHelper;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserService
{
    use ModelHelper;

    public function getAll()
    {
        return User::get();
    }

    public function find($userId)
    {
        return $this->findByIdOrFail(User::class, 'user', $userId);
    }

    public function create()
    {
        $data = [
            'roles'  => Role::orderBy('name')->get(),
            'cities' => City::orderBy('name')->get()
        ];
        return $data;
    }

    public function edit($id)
    {
        $data = [
            'user'   => User::where('id', $id)->first(),
            'roles'  => Role::orderBy('name')->get(),
            'cities' => City::orderBy('name')->get()
        ];
        return $data;
    }

    public function store($validatedData)
    {
        DB::beginTransaction();

        $validatedData['password'] = Hash::make($validatedData['password']);

        $user = User::create($validatedData);

        $user->assignRole($validatedData['role']);

        DB::commit();

        return $user;
    }

    public function update($validatedData, $userId)
    {
        $user = $this->findByIdOrFail(User::class, 'user', $userId);

        DB::beginTransaction();
        $validatedData['password'] = $validatedData['password'] ? Hash::make($validatedData['password']) : $user->password;

        $user->update($validatedData);
        $user->assignRole($validatedData['role']);
        DB::commit();

        return $user;
    }

    public function delete($userId)
    {
        $user = $this->find($userId);

        DB::beginTransaction();

        $user->clearMediaCollection('profile');
        $user->delete();


        DB::commit();

        return true;
    }

    public function bulkDelete($checked)
    {
        $users = User::whereIn('id', $checked)->get();

        DB::beginTransaction();

        foreach ($users as $user) {
            $user->clearMediaCollection('profile');
            $user->delete();
        }

        DB::commit();

        return true;
    }

    public function status($userId)
    {
        $user = $this->find($userId);

        DB::beginTransaction();

        if ($user->status == 0) {
            $user->status = 1;
            $user->save();
            $message = [
                'status'   => 'success',
                'message'  => 'Status changed to active !',
            ];
        } else {
            $user->status = 0;
            $user->save();
            $message = [
                'status'   => 'delete',
                'message'  => 'Status changed to deactive !',
            ];
        }

        DB::commit();

        return $message;
    }
}

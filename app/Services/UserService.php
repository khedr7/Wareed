<?php

namespace App\Services;

use App\Models\City;
use App\Models\Day;
use App\Models\State;
use Illuminate\Support\Facades\DB;
use App\Traits\ModelHelper;
use App\Models\User;
use Codebyray\ReviewRateable\Models\Rating;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserService
{
    use ModelHelper;

    public function getAll()
    {
        return User::with('days')->where('accepted', 1)->orderBy('role', 'asc')->get();
    }

    public function indexProviders()
    {
        return User::with('days')->where('role', 'provider')->where('accepted', 1)->get();
    }

    public function providersRequests()
    {
        return User::with('days')->where('role', 'provider')->where('accepted', 0)->get();
    }

    public function getTopRated()
    {
        return User::with('days')->withAvg('userRating', 'rating')
            ->where('accepted', 1)->where('status', 1)->where('role', 'provider')
            ->orderByDesc('user_rating_avg_rating')
            ->get()->take(5);
    }

    public function getAllProviders($request)
    {
        return User::with(['days', 'city.state'])->withAvg('userRating', 'rating')->where('accepted', 1)->where('status', 1)->where('role', 'provider')->app();
    }

    public function unacceptedUsers()
    {
        return User::with('days')->where('accepted', 0)->orderBy('role', 'asc')->get();
    }

    public function allReviews()
    {
        $reviews = Rating::with(['author', 'reviewrateable'])->orderBy('id', 'desc')->get();
        return $reviews;
    }

    public function providerReviews($userId)
    {
        $user = User::with(['userRating' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }, 'userRating.author'])
            ->where('id', $userId)->first();
        return $user;
    }

    public function find($userId)
    {
        return User::with('userAppRating.author')->findOrFail($userId);
    }

    public function create()
    {
        $data = [
            'roles'  => Role::orderBy('name')->get(),
            'cities' => City::orderBy('name')->get(),
            'states' => State::orderBy('name')->get(),
            'days'   => Day::orderBy('id')->get()
        ];
        return $data;
    }

    public function edit($id)
    {
        $data = [
            'user'   => User::where('id', $id)->with(['city', 'days'])->first(),
            'roles'  => Role::orderBy('name')->get(),
            'cities' => City::orderBy('name')->get(),
            'states' => State::orderBy('name')->get(),
            'days'   => Day::orderBy('id')->get()
        ];
        return $data;
    }

    public function store($validatedData)
    {

        DB::beginTransaction();

        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['accepted'] = 1;

        $user = User::create($validatedData);

        $user->assignRole($validatedData['role']);
        if (isset($validatedData['days']))
            $user->days()->sync($validatedData['days']);

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
        if (!isset($validatedData['days']))
            $validatedData['days'] = [];
        $user->days()->sync($validatedData['days']);

        DB::commit();

        return $user;
    }

    public function addPoints($validatedData, $userId)
    {
        $user = $this->findByIdOrFail(User::class, 'user', $userId);

        DB::beginTransaction();
        $user->points += $validatedData['points'];
        $user->save();
        DB::commit();

        return $user;
    }

    public function delete($userId)
    {
        $user = $this->find($userId);

        DB::beginTransaction();

        $user->clearMediaCollection('profile');
        $user->orders()->delete();
        $user->providerOrders()->delete();
        $user->requests()->delete();
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
            $user->orders()->delete();
            $user->providerOrders()->delete();
            $user->requests()->delete();
            $user->delete();
        }

        DB::commit();

        return true;
    }

    public function deleteReviews($reviewId)
    {
        $review = Rating::where('id', $reviewId)->first();

        DB::beginTransaction();
        $review->delete();

        DB::commit();

        return true;
    }

    public function reviewsBulkDelete($checked)
    {
        $reviews = Rating::whereIn('id', $checked)->get();

        DB::beginTransaction();

        foreach ($reviews as $user) {
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

    public function accept($userId)
    {
        $user = $this->find($userId);

        DB::beginTransaction();

        if ($user->accepted == 0) {
            $user->status   = 1;
            $user->accepted = 1;
            $user->save();
            $message = [
                'status'   => 'success',
                'message'  => 'Status changed to active !',
            ];
        } else {
            $user->accepted = 0;
            $user->save();
            $message = [
                'status'   => 'delete',
                'message'  => 'Status changed to deactive !',
            ];
        }

        DB::commit();

        return $message;
    }

    public function reviewApprove($reviewId)
    {
        $review = Rating::where('id', $reviewId)->first();

        DB::beginTransaction();

        if ($review->approved == 0) {
            $review->approved = 1;
            $review->save();
            $message = [
                'status'   => 'success',
                'message'  => 'Status changed to active !',
            ];
        } else {
            $review->approved = 0;
            $review->save();
            $message = [
                'status'   => 'delete',
                'message'  => 'Status changed to deactive !',
            ];
        }

        DB::commit();

        return $message;
    }
}

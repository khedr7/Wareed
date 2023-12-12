<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Traits\ModelHelper;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ReviewService
{
    use ModelHelper;

    public function getAll()
    {
        $provider = User::findOrFail(request()->provider_id);
        return $provider->getAllRatings($provider->id);
    }

    public function find($reviewId)
    {
        return $this->findOrFail($reviewId);
    }

    public function create($validatedData)
    {
        DB::beginTransaction();
        $provider = User::findOrFail(request()->provider_id);
        $user = Auth::user();
        $rating = $provider->rating([
            'title' => $validatedData['title'],
            'body' => $validatedData['body'],
            'rating' => $validatedData['rating'],
            'approved' => 1,
        ], $user);

        DB::commit();

        return $rating;
    }

    public function update($validatedData, $reviewId)
    {
        $review = $this->findOrFail($reviewId);

        DB::beginTransaction();

        $review->update($validatedData);

        DB::commit();

        return true;
    }

    public function delete($reviewId)
    {
        $review = $this->find($reviewId);

        DB::beginTransaction();

        $review->delete();

        DB::commit();

        return true;
    }
}

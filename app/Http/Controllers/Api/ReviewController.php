<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Services\ReviewService;

class ReviewController extends Controller
{
    public function __construct(private ReviewService $reviewService)
    {
    }

    public function getAll()
    {
        $reviews = $this->reviewService->getAll();
        return $this->successResponse(
            $this->resource($reviews, ReviewResource::class),
            'dataFetchedSuccessfully'
        );
    }

    public function find($reviewId)
    {
        $review = $this->reviewService->find($reviewId);

        return $this->successResponse(
            $this->resource($review, ReviewResource::class),
            'dataFetchedSuccessfully'
        );
    }

    public function create(ReviewRequest $request)
    {
        $validatedData = $request->validated();
        $review = $this->reviewService->create($validatedData);

        return $this->successResponse(
            $this->resource($review, ReviewResource::class),
            'dataAddedSuccessfully'
        );
    }

    public function update(ReviewRequest $request, $reviewId)
    {
        $validatedData = $request->validated();
        $this->reviewService->update($validatedData, $reviewId);

        return $this->successResponse(
            null,
            'dataUpdatedSuccessfully'
        );
    }

    public function delete($reviewId)
    {
        $this->reviewService->delete($reviewId);

        return $this->successResponse(
            null,
            'dataDeletedSuccessfully'
        );
    }
}

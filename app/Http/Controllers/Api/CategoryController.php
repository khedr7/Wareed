<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;


class CategoryController extends Controller
{
    public function __construct(private CategoryService $categoryService)
    {
    }

    public function getAll()
    {
        $categories = $this->categoryService->getAll();

        return $this->successResponse(
            $this->resource($categories, CategoryResource::class),
            'dataFetchedSuccessfully'
        );
    }

    public function find($categoryId)
    {
        $category = $this->categoryService->find($categoryId);

        return $this->successResponse(
            $this->resource($category, CategoryResource::class),
            'dataFetchedSuccessfully'
        );
    }
}

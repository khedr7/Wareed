<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(private CategoryService $categoryService)
    {
    }

    public function index(Request $request)
    {
        $categories = $this->categoryService->getAll();

        return view('categories.index', compact("categories"));
    }

    public function find($categoryId)
    {
        $category = $this->categoryService->find($categoryId);

        return $this->successResponse(
            $this->resource($category, CategoryResource::class),
            'dataFetchedSuccessfully'
        );
    }

    public function store(CategoryRequest $request)
    {
        $validatedData = $request->validated();

        $category = $this->categoryService->store($validatedData);
        if ($request->file('image') && $request->file('image')->isValid()) {
            $category->addMedia($request->image)->toMediaCollection('image');
        }

        return redirect('categories')->with('success', __('messages.dataAddedSuccessfully'));
    }

    public function update(CategoryRequest $request, $categoryId)
    {
        $validatedData = $request->validated();
        $category = $this->categoryService->update($validatedData, $categoryId);

        if ($request->file('image') && $request->file('image')->isValid()) {
            $category->clearMediaCollection('image');
            $category->addMedia($request->image)->toMediaCollection('image');
        }

        return redirect('categories')->with('success', __('messages.dataUpdatedSuccessfully'));
    }

    public function delete($categoryId)
    {
        $this->categoryService->delete($categoryId);

        return redirect('categories')->with('success', __('messages.dataDeletedSuccessfully'));
    }
}

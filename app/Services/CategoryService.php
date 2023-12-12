<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Traits\ModelHelper;
use App\Models\Category;

class CategoryService
{
    use ModelHelper;

    public function getAll()
    {
        return Category::orderBy('id', 'desc')->get();
    }

    public function getAllApp()
    {
        return Category::with('services:id,name,category_id')->orderBy('name', 'asc')->get();
    }

    public function find($categoryId)
    {
        return $this->findByIdOrFail(Category::class, 'category', $categoryId);
    }

    public function store($validatedData)
    {
        DB::beginTransaction();

        $validatedData['name'] = [
            'en' => $validatedData['name_en'],
            'ar' => $validatedData['name_ar'],
        ];

        $category = Category::create($validatedData);

        DB::commit();

        return $category;
    }

    public function update($validatedData, $categoryId)
    {
        $category = $this->find($categoryId);

        DB::beginTransaction();

        $validatedData['name'] = [
            'en' => $validatedData['name_en'],
            'ar' => $validatedData['name_ar'],
        ];

        $category->update($validatedData);

        DB::commit();

        return $category;
    }

    public function delete($categoryId)
    {
        $category = $this->find($categoryId);

        DB::beginTransaction();

        $category->clearMediaCollection('image');
        $category->delete();

        DB::commit();

        return true;
    }
}

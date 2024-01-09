<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AboutUsResource;
use App\Services\AboutUsService;

class AboutUsController extends Controller
{
    public function __construct(private AboutUsService $aboutUs_Service)
    {
    }

    public function find()
    {
        $aboutUs = $this->aboutUs_Service->find();

        return $this->successResponse(
            $this->resource($aboutUs, AboutUsResource::class),
            'dataFetchedSuccessfully'
        );
    }
}

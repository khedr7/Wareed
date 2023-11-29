<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Resources\ConfigResource;
use App\Services\HomeService;

class HomeController extends Controller
{
    public function __construct(private HomeService $homeService)
    {
    }

    public function appHomePage()
    {
        $homePageData = $this->homeService->getAppHomePageData();

        return $this->successResponse(
            $this->resource($homePageData, ConfigResource::class),
            'dataFetchedSuccessfully'
        );
    }
}

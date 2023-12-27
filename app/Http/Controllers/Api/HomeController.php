<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Resources\ConfigResource;
use App\Services\HomeService;
use Illuminate\Support\Facades\Request;

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

    public function config()
    {
        $config = $this->homeService->config();

        return $this->successResponse(
            $this->resource($config, ConfigResource::class),
            'dataFetchedSuccessfully'
        );
    }
}

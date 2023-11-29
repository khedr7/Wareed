<?php

namespace App\Services;


use App\Traits\ModelHelper;
use Exception;

class HomeService
{
    use ModelHelper;

    public function __construct(
        private BannerService   $bannerService,
        private CategoryService $categoryService,
        private ServiceService  $serviceService,
        private UserService     $userService,

    ) {
    }

    public function getAppHomePageData(): array
    {
        return [
            'banners'      => $this->bannerService->getAllActive(),
            'categories'   => $this->categoryService->getAll(),
            'topServices'  => $this->serviceService->getTopRated(),
            'topProviders' => $this->userService->getTopRated(),
        ];
    }
}

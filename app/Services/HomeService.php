<?php

namespace App\Services;

use App\Models\Day;
use App\Models\Setting;
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
        private StateService    $stateService,
        private PaymentMethodService    $paymentMethodService,
    ) {
    }

    public function getAppHomePageData(): array
    {
        return [
            'banners'      => $this->bannerService->getAllActive(),
            'categories'   => $this->categoryService->getAll(),
            'topServices'  => $this->serviceService->getTopRated(), //Featured
            'topProviders' => $this->userService->getTopRated(),
        ];
    }

    public function config(): array
    {
        return [
            'states'           => $this->stateService->getAllApp(),
            'categories'       => $this->categoryService->getAllApp(),
            'payment_methodes' => $this->paymentMethodService->getAllApp(),
            'days'             => Day::get(),
            'settings'         => Setting::first(),
        ];
    }

}

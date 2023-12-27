<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class ConfigResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $actionMethod = $request->route()->getActionMethod();
        return match ($actionMethod) {
            'appHomePage' => $this->appHomePage(),
            'config'      => $this->config(),
            default => []
        };
    }

    public function appHomePage()
    {
        return [
            'banners'      => BannerResource::collection($this->resource['banners']),
            'categories'   => CategoryResource::collection($this->resource['categories']),
            'topServices'  => ServiceResource::collection($this->resource['topServices']),
            'topProviders' => UserResource::collection($this->resource['topProviders']),
        ];
    }

    public function config()
    {
        return [
            'states'            => StateResource::collection($this->resource['states']),
            'categories'        => CategoryResource::collection($this->resource['categories']),
            'payment_methodes'  => PaymentMethodResource::collection($this->resource['payment_methodes']),
            'days'              => DayResource::collection($this->resource['days']),
        ];
    }
}

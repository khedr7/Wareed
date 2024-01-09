<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
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
            'getAll' => $this->getAllResource(),
            default => $this->defaultResource(),
        };
    }

    public function getAllResource()
    {
        return [
            'point_price'              => (float) $this->point_price,
            'wareed_service_percent'   => (float) $this->wareed_service_percent,
        ];
    }

    public function defaultResource()
    {
        return [
            'point_price'              => (float) $this->point_price,
            'wareed_service_percent'   => (float) $this->wareed_service_percent,
        ];
    }
}

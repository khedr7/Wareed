<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if (request()->routeIs('app.user.find') || request()->routeIs('app.home')) {
            return $this->getForProvider();
        }
        $actionMethod = $request->route()->getActionMethod();
        return match ($actionMethod) {
            'getAll' => $this->getAllResource(),
            default => $this->defaultResource(),
        };
    }

    public function getAllResource()
    {
        return [
            'id'                 => $this->id,
            'name'               => $this->name,
            'details'            => $this->details,
            'price'              => $this->price,
            // 'latitude'           => $this->latitude,
            // 'longitude'          => $this->longitude,
            'status'             => $this->status,
            'featured'           => $this->featured,
            'on_patient_site'    => $this->on_patient_site,
            'category_id'        => $this->category_id,
            'user_id'            => $this->user_id,
            'image'              => $this->image,
            'created_at'         => $this->created_at,
            'category'           => CategoryResource::make($this->category),
            'user'               => UserResource::make($this->user),
        ];
    }

    public function defaultResource()
    {
        return [
            'id'                 => $this->id,
            'name'               => $this->name,
            'details'            => $this->details,
            'price'              => $this->price,
            // 'latitude'           => $this->latitude,
            // 'longitude'          => $this->longitude,
            'status'             => $this->status,
            'featured'           => $this->featured,
            'on_patient_site'    => $this->on_patient_site,
            'category_id'        => $this->category_id,
            'user_id'            => $this->user_id,
            'image'              => $this->image,
            'created_at'         => $this->created_at,
            'category'           => CategoryResource::make($this->category),
            'user'               => UserResource::make($this->user),
        ];
    }

    public function getForProvider()
    {
        return [
            'id'                 => $this->id,
            'name'               => $this->name,
            'details'            => $this->details,
            'price'              => $this->price,
            // 'latitude'           => $this->latitude,
            // 'longitude'          => $this->longitude,
            'status'             => $this->status,
            'featured'           => $this->featured,
            'on_patient_site'    => $this->on_patient_site,
            'category_id'        => $this->category_id,
            'user_id'            => $this->user_id,
            'image'              => $this->image,
            'created_at'         => $this->created_at,
            'category'           => CategoryResource::make($this->category),
        ];
    }
}

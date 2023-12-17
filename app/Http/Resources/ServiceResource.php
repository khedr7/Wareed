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
            'config' => $this->config(),
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
            'category_id'        => $this->category_id,
            'image'              => $this->image,
            'created_at'         => $this->created_at,
            'category'           => CategoryResource::make($this->category),
            // 'users'              => UserResource::collection($this->users),
        ];
    }

    public function defaultResource()
    {
        // dd($this->users);
        return [
            'id'                 => $this->id,
            'name'               => $this->name,
            'details'            => $this->details,
            'price'              => $this->price,
            // 'latitude'           => $this->latitude,
            // 'longitude'          => $this->longitude,
            'status'             => $this->status,
            'featured'           => $this->featured,
            'category_id'        => $this->category_id,
            'image'              => $this->image,
            'created_at'         => $this->created_at,
            'category'           => CategoryResource::make($this->category),
            'users'              => UserResource::collection($this->users),
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
            'category_id'        => $this->category_id,
            'image'              => $this->image,
            'created_at'         => $this->created_at,
            'on_patient_site'    => $this->pivot->on_patient_site ?? 0,
            'on_provider_site'   => $this->pivot->on_provider_site ?? 0,
            'category'           => CategoryResource::make($this->category),
        ];
    }

    public function config()
    {
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'image' => $this->image,
        ];
    }
}

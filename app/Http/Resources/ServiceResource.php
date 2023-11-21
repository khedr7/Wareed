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
        $actionMethod = $request->route()->getActionMethod();
        return match ($actionMethod) {
            'getAll' => $this->getAllResource(),
             default => $this->defaultResource(),
        };
    }

    public function getAllResource()
    {
          return [
            'id' => $this->id,
            'name' => $this->name,
            'details' => $this->details,
            'price' => $this->price,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'status' => $this->status,
            'featured' => $this->featured,
            'category_id' => $this->category_id,
            'category_id' => $this->category_id,
            'user_id' => $this->user_id,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at
          ];
    }

    public function defaultResource()
    {
          return [
            'id' => $this->id,
            'name' => $this->name,
            'details' => $this->details,
            'price' => $this->price,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'status' => $this->status,
            'featured' => $this->featured,
            'category_id' => $this->category_id,
            'category_id' => $this->category_id,
            'user_id' => $this->user_id,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at
          ];
    }
}

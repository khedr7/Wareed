<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if (request()->routeIs('app.service.find')) {
            return $this->getAllResource();
        }

        $actionMethod = $request->route()->getActionMethod();
        return match ($actionMethod) {
            'getAll'          => $this->getAllResource(),
            'getAllProviders' => $this->getAllResource(),
            'appHomePage'     => $this->getAllResource(),
            'login'           => $this->getAllResource(),
            'register'        => $this->getAllResource(),
            default           => $this->defaultResource(),
        };
    }

    public function getAllResource()
    {
       
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'email'         => $this->email,
            'address'       => $this->address,
            'profile'       => $this->profile,
            'phone'         => $this->phone,
            'role'          => $this->role,
            'status'        => $this->status,
            'accepted'      => $this->accepted,
            // 'has_residence' => $this->has_residence,
            'gender'        => $this->gender,
            'birthday'      => $this->birthday,
            'details'       => $this->details,
            'latitude'      => $this->latitude,
            'longitude'     => $this->longitude,
            'fcm_token'     => $this->fcm_token,
            'created_at'    => $this->created_at,
            'days'          => $this->days->pluck('name')->toArray(),
            'avg_rating'    => $this->user_rating_avg_rating ?? 0,
            
        ];
    }

    public function defaultResource()
    {

        if ($this->role == 'provider') {
            return [
                'id'            => $this->id,
                'name'          => $this->name,
                'email'         => $this->email,
                'address'       => $this->address,
                'profile'       => $this->profile,
                'phone'         => $this->phone,
                'role'          => $this->role,
                'status'        => $this->status,
                'accepted'      => $this->accepted,
                // 'has_residence' => $this->has_residence,
                'gender'        => $this->gender,
                'birthday'      => $this->birthday,
                'details'       => $this->details,
                'latitude'      => $this->latitude,
                'longitude'     => $this->longitude,
                'fcm_token'     => $this->fcm_token,
                'created_at'    => $this->created_at,
                'days'          => $this->days->pluck('name')->toArray(),
                'services'      => ServiceResource::collection($this->services->where('status', 1)),
                'avg_rating'    => $this->averageRating() ?? 0,
                'reviews'       => ReviewResource::collection($this->userRating) ,


            ];
        } else {
            return [
                'id'            => $this->id,
                'name'          => $this->name,
                'email'         => $this->email,
                'address'       => $this->address,
                'profile'       => $this->profile,
                'phone'         => $this->phone,
                'role'          => $this->role,
                'status'        => $this->status,
                'accepted'      => $this->accepted,
                // 'has_residence' => $this->has_residence,
                'gender'        => $this->gender,
                'birthday'      => $this->birthday,
                'details'       => $this->details,
                'latitude'      => $this->latitude,
                'longitude'     => $this->longitude,
                'fcm_token'     => $this->fcm_token,
                'created_at'    => $this->created_at,
                'days'          => $this->days->pluck('name')->toArray(),
            ];
        }
    }
}

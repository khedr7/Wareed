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
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'password' => $this->password,
            'address' => $this->address,
            'phone' => $this->phone,
            'role' => $this->role,
            'status' => $this->status,
            'has_residence' => $this->has_residence,
            'gender' => $this->gender,
            'birthday' => $this->birthday,
            'details' => $this->details,
            'fcm_token' => $this->fcm_token,
            'created_at' => $this->created_at
          ];
    }

    public function defaultResource()
    {
          return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'password' => $this->password,
            'address' => $this->address,
            'phone' => $this->phone,
            'role' => $this->role,
            'status' => $this->status,
            'has_residence' => $this->has_residence,
            'gender' => $this->gender,
            'birthday' => $this->birthday,
            'details' => $this->details,
            'fcm_token' => $this->fcm_token,
            'created_at' => $this->created_at
          ];
    }
}

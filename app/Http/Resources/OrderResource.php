<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'user_id' => $this->user_id,
            'payment_method_id' => $this->payment_method_id,
            'status' => $this->status,
            'payment_status' => $this->payment_status,
            'date' => $this->date,
            'note' => $this->note,
            'user' => $this->user->only('id','name','phone','latitude','longitude','address') ?? [],
            'provider' => $this->provider->only('id','name','latitude','longitude','address') ?? [],
            'service' => $this->service->only('id','name','details','price'),
            'patients_number' => $this->patients_number,
            'end_date' => $this->end_date,
            'on_patient_site' => $this->on_patient_site,
            'created_at' => $this->created_at
          ];
    }

    public function defaultResource()
    {
      return [
        'id' => $this->id,
        'user_id' => $this->user_id,
        'payment_method_id' => $this->payment_method_id,
        'status' => $this->status,
        'payment_status' => $this->payment_status,
        'date' => $this->date,
        'note' => $this->note,
        'user' => $this->user->only('id','name','phone','latitude','longitude','address') ?? [],
        'provider' => $this->provider->only('id','name','latitude','longitude','address') ?? [],
        'service' => $this->service->only('id','name','details','price'),
        'patients_number' => $this->patients_number,
        'end_date' => $this->end_date,
        'created_at' => $this->created_at
      ];
    }
}

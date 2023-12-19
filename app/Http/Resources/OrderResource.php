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
            'id'                => $this->id,
            'user_id'           => $this->user_id,
            'payment_method_id' => $this->payment_method_id,
            'payment_method'    => $this->paymentMethod ? $this->paymentMethod->name : null,
            'status'            => $this->status,
            'payment_status'    => $this->payment_status,
            'date'              => $this->date,
            'end_date'          => $this->end_date,
            'note'              => $this->note,
            'user'              => $this->user ? $this->user->only('id', 'name', 'phone', 'latitude', 'longitude', 'address') : null,
            'provider'          => $this->provider ? $this->provider->only('id', 'name', 'phone', 'latitude', 'longitude', 'address') : null,
            'service'           =>  $this->service ? $this->service->only('id', 'name', 'details', 'price') : null,
            'patients_number'   => $this->patients_number,
            'on_patient_site'   => $this->on_patient_site,
            'created_at'        => $this->created_at
        ];
    }

    public function defaultResource()
    {
        return [
            'id'                => $this->id,
            'user_id'           => $this->user_id,
            'payment_method_id' => $this->payment_method_id,
            'payment_method'    => $this->paymentMethod ? $this->paymentMethod->name : null,
            'status'            => $this->status,
            'payment_status'    => $this->payment_status,
            'date'              => $this->date,
            'end_date'          => $this->end_date,
            'note'              => $this->note,
            'user'              => $this->user ? $this->user->only('id', 'name', 'phone', 'latitude', 'longitude', 'address') : null,
            'provider'          => $this->provider ? $this->provider->only('id', 'name', 'phone', 'latitude', 'longitude', 'address') : null,
            'service'           => $this->service ? $this->service->only('id', 'name', 'details', 'price') : null,
            'patients_number'   => $this->patients_number,
            'created_at'        => $this->created_at
        ];
    }
}

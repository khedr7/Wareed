<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'id'           => $this->id,
            'title'        => $this->title,
            'body'         => $this->body,
            // 'by_admin'     => $this->by_admin,
            // 'to_type'      => $this->to_type,
            'service_type' => $this->service_type,
            'service_id'   => $this->service_id,
            'order_status' => $this->order ? $this->order->status : null,
            'seen'         => (int) $this->pivot->seen ?? 0,
            'seen_at'      => $this->pivot->seen_at ?? null,
            'created_at'   => $this->created_at
        ];
    }

    public function defaultResource()
    {
        return [
            'id'           => $this->id,
            'title'        => $this->title,
            'body'         => $this->body,
            // 'by_admin'     => $this->by_admin,
            // 'to_type'      => $this->to_type,
            'service_type' => $this->service_type,
            'service_id'   => $this->service_id,
            'order_status' => $this->order ? $this->order->status : null,
            'seen'         => (int) $this->pivot->seen ?? 0,
            'seen_at'      => $this->pivot->seen_at ?? null,
            'created_at'   => $this->created_at
        ];
    }
}

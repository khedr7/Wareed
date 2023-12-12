<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ComplaintReplyResource extends JsonResource
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
            'details'      => $this->details,
            'user_id'      => $this->user_id,
            // 'complaint_id' => $this->complaint_id,
            'created_at'   => $this->created_at
        ];
    }

    public function defaultResource()
    {
        return [
            'id'           => $this->id,
            'details'      => $this->details,
            'user_id'      => $this->user_id,
            // 'complaint_id' => $this->complaint_id,
            'created_at'   => $this->created_at
        ];
    }
}

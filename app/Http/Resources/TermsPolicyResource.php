<?php

namespace App\Http\Resources;

use App\Models\AboutUs;
use Illuminate\Http\Resources\Json\JsonResource;

class TermsPolicyResource extends JsonResource
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
        $about = AboutUs::first();
        return [
            // 'id'         => $this->id,
            'terms'      => $this->terms,
            'policy'     => $this->policy,
            'about'      => $about->details,
            // 'created_at' => $this->created_at
        ];
    }

    public function defaultResource()
    {
        $about = AboutUs::first();
        return [
            // 'id'     => $this->id,
            'terms'  => $this->terms,
            'policy' => $this->policy,
            'about'      => $about->details,
            // 'created_at' => $this->created_at
        ];
    }
}

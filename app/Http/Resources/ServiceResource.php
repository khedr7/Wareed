<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        if (request()->routeIs('app.user.find')) {
            return $this->getForProvider();
        }
        if (request()->routeIs('app.home')) {
            return $this->getForHomeProvider();
        }
        if (request()->routeIs('app.service.getForProviderChange')) {
            return $this->getForProviderChange();
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
        return [
            'id'                 => $this->id,
            'name'               => $this->name,
            'details'            => $this->details,
            'price'              => $this->price,
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
            'status'             => $this->status,
            'featured'           => $this->featured,
            'category_id'        => $this->category_id,
            'image'              => $this->image,
            'created_at'         => $this->created_at,
            'on_patient_site'    => (int) $this->pivot->on_patient_site ?? 0,
            'on_provider_site'   => (int) $this->pivot->on_provider_site ?? 0,
            'category'           => CategoryResource::make($this->category),
        ];
    }

    public function getForHomeProvider()
    {
        return [
            'id'                 => $this->id,
            'name'               => $this->name,
            'details'            => $this->details,
            'price'              => $this->price,
            'status'             => $this->status,
            'featured'           => $this->featured,
            'category_id'        => $this->category_id,
            'image'              => $this->image,
            'created_at'         => $this->created_at,
            'category'           => CategoryResource::make($this->category),
        ];
    }

    public function getForProviderChange()
    {
        if (Auth::guard('sanctum')->user()) {
            $pivotRow = DB::table('service_user')
                ->where('user_id', Auth::guard('sanctum')->user()->id)
                ->where('service_id', $this->id)
                ->first();

            if (isset($pivotRow)) {
                return [
                    'id'                 => $this->id,
                    'name'               => $this->name,
                    'category_name'      => $this->category->name,
                    'image'              => $this->image,
                    'provides_service'   => 1,
                    'on_patient_site'    => (int) $pivotRow->on_patient_site,
                    'on_provider_site'   => (int) $pivotRow->on_provider_site,
                ];
            }
        }
        return [
            'id'                 => $this->id,
            'name'               => $this->name,
            'category_name'      => $this->category->name,
            'image'              => $this->image,
            'provides_service'   => 0,
            'on_patient_site'    => 0,
            'on_provider_site'   => 0,
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

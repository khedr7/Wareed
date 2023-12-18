<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return match ($this->route()->getActionMethod()) {
            'store'    =>  $this->getCreateRules(),
            'update'   =>  $this->getUpdateRules(),
            'ChangeProviderServices'   =>  $this->ChangeProviderServices(),
        };
    }

    public function getCreateRules()
    {
        return [
            'name_en'            => 'required',
            'name_ar'            => 'required',
            'details_en'         => '',
            'details_ar'         => '',
            'price'              => 'nullable|numeric',
            // 'latitude'           => 'nullable|numeric',
            // 'longitude'          => 'nullable|numeric',
            'status'             => '',
            'featured'           => '',
            'image'              => 'required|nullable|image|mimes:png,jpg,jpeg',
            'category_id'        => 'required|exists:categories,id',
            'keys'               => '',
        ];
    }

    public function getUpdateRules()
    {
        return [
            'name_en'            => 'required',
            'name_ar'            => 'required',
            'details_en'         => '',
            'details_ar'         => '',
            'price'              => 'nullable|numeric',
            // 'latitude'           => 'nullable|numeric',
            // 'longitude'          => 'nullable|numeric',
            'status'             => '',
            'featured'           => '',
            'image'              => 'sometimes|nullable|image|mimes:png,jpg,jpeg',
            'category_id'        => 'required|exists:categories,id',
            'keys'               => '',
        ];
    }

    public function ChangeProviderServices()
    {
        return [
            'services'                   => 'array',
            'service.*.service_id'       => 'exists:services,id',
            'service.*.on_patient_site'  => 'boolean',
            'service.*.on_provider_site' => 'boolean',
        ];
    }
}

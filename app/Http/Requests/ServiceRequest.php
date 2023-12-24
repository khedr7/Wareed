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
            'changeProviderServices' =>  $this->changeProviderServices(),
            'addProviderServices'    =>  $this->addProviderServices(),
            'removeProviderServices' =>  $this->removeProviderServices(),
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

    public function changeProviderServices()
    {
        return [
            'services'                   => 'array',
            'service.*.service_id'       => 'exists:services,id',
            'service.*.on_patient_site'  => 'boolean',
            'service.*.on_provider_site' => 'boolean',
        ];
    }

    public function addProviderServices()
    {
        return [
            'service_id'       => 'required|exists:services,id',
            'on_patient_site'  => 'required|boolean',
            'on_provider_site' => 'required|boolean',
        ];
    }

    public function removeProviderServices()
    {
        return [
            'service_id' => 'required|exists:services,id',
        ];
    }
}

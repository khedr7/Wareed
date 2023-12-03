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
            'store'   =>  $this->getCreateRules(),
            'update'   =>  $this->getUpdateRules(),
        };
    }

    public function getCreateRules()
    {
        return [
            'name'               => 'required',
            'details'            => '',
            'price'              => 'nullable|numeric',
            'latitude'           => 'nullable|numeric',
            'longitude'          => 'nullable|numeric',
            'status'             => '',
            'featured'           => '',
            'on_patient_site'    => '',
            'image'              => 'required|nullable|image|mimes:png,jpg,jpeg',
            'category_id'        => 'required|exists:categories,id',
            'user_id'            => 'required|exists:users,id',
        ];
    }

    public function getUpdateRules()
    {
        return [
            'name'               => 'required',
            'details'            => '',
            'price'              => 'nullable|numeric',
            'latitude'           => 'nullable|numeric',
            'longitude'          => 'nullable|numeric',
            'status'             => '',
            'featured'           => '',
            'on_patient_site'    => '',
            'image'              => 'sometimes|nullable|image|mimes:png,jpg,jpeg',
            'category_id'        => 'required|exists:categories,id',
            'user_id'            => 'required|exists:users,id',
        ];
    }
}

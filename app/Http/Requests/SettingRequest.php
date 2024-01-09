<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
            'create'   =>  $this->getCreateRules(),
            'update'   =>  $this->getUpdateRules(),
        };
    }

    public function getCreateRules()
    {
        return [
            'point_price'            => 'required|numeric',
            'wareed_service_percent' => 'required|numeric'
        ];
    }

    public function getUpdateRules()
    {
        return [
            'point_price'            => 'required|numeric',
            'wareed_service_percent' => 'required|numeric'
        ];
    }
}

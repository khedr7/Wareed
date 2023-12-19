<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequestRequest extends FormRequest
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
            'orderService'   =>  $this->getorderServiceRules(),
        };
    }

    public function getCreateRules()
    {
        return [
            'title' => '',
            'details' => '',
            'user_id' => '',
            'user_id' => ''
        ];
    }

    public function getUpdateRules()
    {
        return [
            'title' => '',
            'details' => '',
            'user_id' => '',
            'user_id' => ''
        ];
    }

    public function getorderServiceRules()
    {
        return [
            'title'   => 'required',
            'details' => 'required',
        ];
    }
}

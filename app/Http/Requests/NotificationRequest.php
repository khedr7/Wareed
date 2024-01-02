<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotificationRequest extends FormRequest
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
            'by_admin' => '',
            'to_type' => '',
            'service_type' => '',
            'service_id' => ''
          ];
    }

    public function getUpdateRules()
    {
          return [
            'by_admin' => '',
            'to_type' => '',
            'service_type' => '',
            'service_id' => ''
          ];
    }
}

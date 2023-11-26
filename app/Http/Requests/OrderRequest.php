<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'status'   =>  $this->getStatusRules(),
        };
    }

    public function getCreateRules()
    {
        return [
            'user_id' => '',
            'service_id' => '',
            'payment_method_id' => '',
            'status' => '',
            'payment_status' => '',
            'date' => '',
            'note' => '',
            'user_id' => '',
            'service_id' => '',
            'payment_method_id' => ''
        ];
    }

    public function getUpdateRules()
    {
        return [
            'user_id' => '',
            'service_id' => '',
            'payment_method_id' => '',
            'status' => '',
            'payment_status' => '',
            'date' => '',
            'note' => '',
            'user_id' => '',
            'service_id' => '',
            'payment_method_id' => ''
        ];
    }

    public function getStatusRules()
    {
        return [
            'status' => 'required|in:Confirmed,Pending,Cancelled',
        ];
    }
}

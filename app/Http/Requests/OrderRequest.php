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
            'create'   =>  $this->getCreateRules(),
            'update'   =>  $this->getUpdateRules(),
            'status'   =>  $this->getStatusRules(),
        };
    }

    public function getCreateRules()
    {
        return [
            'user_id'           => '',
            'service_id'        => 'required|exists:services,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            // 'status'            => 'sometimes|required',
            'payment_status'    => 'sometimes|required|boolean',
            'date'              => 'required|date',
            'note'              => 'nullable|string',
            'patients_number'   => 'sometimes|required|integer',
            'end_date'          => 'required|date',
            'provider_id'       => 'required|exists:users,id',
            'on_patient_site'   => 'sometimes|required|boolean',
        ];
    }

    public function getUpdateRules()
    {
        return [
            'user_id'           => '',
            'service_id'        => 'sometimes|required|exists:services,id',
            'payment_method_id' => 'sometimes|required|exists:payment_methods,id',
            'status'            => 'sometimes|required|boolean',
            'payment_status'    => 'sometimes|required|boolean',
            'date'              => 'sometimes|required|date',
            'note'              => 'nullable|string',
            'patients_number'   => 'sometimes|required|integer',
            'end_date'          => 'sometimes|required|date',
            'provider_id'       => 'sometimes|required|exists:users,id',
            'on_patient_site'   => 'sometimes|required|boolean',
        ];
    }

    public function getStatusRules()
    {
        return [
            'status' => 'required|in:Confirmed,Pending,Cancelled',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TermsPolicyRequest extends FormRequest
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
            'terms_en' => '',
            'terms_ar' => '',
            'policy_en' => '',
            'policy_ar' => ''
        ];
    }

    public function getUpdateRules()
    {
        return [
            'terms_en' => '',
            'terms_ar' => '',
            'policy_en' => '',
            'policy_ar' => ''
        ];
    }
}

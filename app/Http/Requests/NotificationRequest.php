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
            'store'   =>  $this->getCreateRules(),
        };
    }

    public function getCreateRules()
    {
        return [
            'title_en'   => 'required',
            'title_ar'   => 'required',
            'details_en' => 'required',
            'details_ar' => 'required',
            'to_type'    => 'required',
        ];
    }
}

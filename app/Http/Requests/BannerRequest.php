<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
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
        };
    }

    public function getCreateRules()
    {
        return [
            'link'            => 'required',
            'start_date'      => 'required|date',
            'expiration_date' => 'nullable|date|after:start_date',
            'status'          => '',
            'image'   => 'required|image|mimes:png,jpg,jpeg',
        ];
    }

    public function getUpdateRules()
    {
        return [
            'link'            => 'required',
            'start_date'      => 'required|date',
            'expiration_date' => 'nullable|date|after:start_date',
            'status'          => '',
            'image'   => 'sometimes|nullable|image|mimes:png,jpg,jpeg',
        ];
    }
}

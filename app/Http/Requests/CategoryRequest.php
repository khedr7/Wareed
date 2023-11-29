<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'update'  =>  $this->getUpdateRules(),
        };
    }

    public function getCreateRules()
    {
        return [
            'name_en' => 'required|min:2',
            'name_ar' => 'required|min:2',
            'image'   => 'required|image|mimes:png,jpg,jpeg',
        ];
    }

    public function getUpdateRules()
    {
        return [
            'name_en' => 'required|min:2',
            'name_ar' => 'required|min:2',
            'image'   => 'sometimes|nullable|image|mimes:png,jpg,jpeg',
        ];
    }
}

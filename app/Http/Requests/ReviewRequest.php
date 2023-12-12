<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            'id' => '',
            'rating' => '',
            'customer_service_rating' => '',
            'quality_rating' => '',
            'friendly_rating' => '',
            'pricing_rating' => '',
            'recommend' => '',
            'department' => '',
            'title' => '',
            'body' => '',
            'approved' => '',
            'reviewrateable' => '',
            'author' => ''
          ];
    }

    public function getUpdateRules()
    {
          return [
            'id' => '',
            'rating' => '',
            'customer_service_rating' => '',
            'quality_rating' => '',
            'friendly_rating' => '',
            'pricing_rating' => '',
            'recommend' => '',
            'department' => '',
            'title' => '',
            'body' => '',
            'approved' => '',
            'reviewrateable' => '',
            'author' => ''
          ];
    }
}

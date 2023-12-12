<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ComplaintReplyRequest extends FormRequest
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
            'reply'    =>  $this->getCreateRules(),
        };
    }

    public function getCreateRules()
    {
        return [
            'details'      => 'required',
            'user_id'      => '',
            'complaint_id' => 'required',
        ];
    }

    public function getUpdateRules()
    {
        return [
            'details'      => 'required',
            'user_id'      => '',
            'complaint_id' => 'required',
        ];
    }
}

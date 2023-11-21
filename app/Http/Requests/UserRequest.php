<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'store'       =>  $this->getCreateRules(),
            'update'      =>  $this->getUpdateRules(),
            'generateOTP' =>  $this->generateOTP(),
            'verifyOTP'   =>    $this->verifyOTP(),
        };
    }

    public function getCreateRules()
    {
        return [
            'name'          => 'required|min:3',
            'email'         => 'required|email',
            'password'      => 'required|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/',
            'address'       => '',
            'phone'         => 'required|min:9|max:10|unique:users,phone',
            'role'          => 'required|exists:roles,name',
            'city_id'       => 'required|exists:cities,id',
            'status'        => '',
            'has_residence' => '',
            'gender'        => 'required',
            'birthday'      => '',
            'profile'       => 'sometimes|nullable|image|mimes:png,jpg,jpeg',
            'details'       => '',
            'fcm_token'     => ''
        ];
    }

    public function getUpdateRules()
    {
        return [
            'name'          => 'required|min:3',
            'email'         => 'required|email',
            'password'      => 'nullable|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/',
            'address'       => '',
            'phone'         => 'required|min:9|max:10|unique:users,phone,' . request()->old_phone . ',phone',
            'role'          => 'required|exists:roles,name',
            'city_id'       => 'required|exists:cities,id',
            'status'        => '',
            'has_residence' => '',
            'gender'        => 'required',
            'birthday'      => '',
            'details'       => '',
            'profile'       => 'sometimes|nullable|image|mimes:png,jpg,jpeg',
            'fcm_token'     => ''
        ];
    }
    public function generateOTP()
    {
        return [
            'phone'   => 'required|min:9|max:10|exists:users,phone',
        ];
    }
    public function verifyOTP()
    {
        return [
            'otp'   => 'required',
            'phone'   => 'required',
        ];
    }

}

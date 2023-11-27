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
            'store'           =>  $this->getCreateRules(),
            'update'          =>  $this->getUpdateRules(),
            'generateOTP'     =>  $this->generateOTP(),
            'verifyOTP'       =>  $this->verifyOTP(),
            'resetPassword'   =>  $this->resetPassword(),
            'updateProfile'   =>  $this->getUpdateRules(),
            'register'        =>  $this->getCreateRules(),
            'addPoints'   =>  $this->getAddPointsRules(),
        };
    }

    public function getCreateRules()
    {
        return [
            'name'          => 'required|min:3',
            'email'         => 'required|email',
            'password'      => 'required|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x]).*$/',
            'address'       => '',
            'phone'         => 'required|min:9|max:10|unique:users,phone',
            'role'          => 'sometimes|required|exists:roles,name',
            'city_id'       => 'sometimes|required|exists:cities,id',
            'status'        => '',
            'has_residence' => '',
            'gender'        => 'required',
            'birthday'      => '',
            'profile'       => 'sometimes|nullable|image|mimes:png,jpg,jpeg',
            'details'       => '',
            'points'        => 'nullable|numeric',
            'fcm_token'     => ''
        ];
    }

    public function getUpdateRules()
    {
        return [
            'name'                 => 'sometimes|required|min:3',
            'email'                => 'sometimes|required|email|unique:users,email,' . auth()->id(),
            'password'             => 'nullable|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x]).*$/',
            'address'              => '',
            // 'phone'                => 'sometimes|required|min:9|max:10|unique:users,phone,' . request()->old_phone . ',phone',
            'role'                 => 'sometimes|required|exists:roles,name',
            'city_id'              => 'sometimes|required|exists:cities,id',
            'status'               => 'sometimes|required|boolean',
            'has_residence'        => '',
            'gender'               => 'sometimes|required',
            'birthday'             => 'sometimes|required|date',
            'details'              => '',
            'profile'              => 'sometimes|required|image|mimes:png,jpg,jpeg',
            'fcm_token'            => '',
            'confirm_password'     => 'sometimes|required|same:password'
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
    public function resetPassword()
    {
        return [
            'phone'            => 'required|exists:users,phone',
            'password'         => 'required|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x]).*$/',
            'confirm_password' => 'required|same:password',
            'name'          => 'required|min:3',
            'email'         => 'required|email',
            'password'      => 'nullable|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/',
            'address'       => '',
            // 'phone'         => 'required|min:9|max:10|unique:users,phone,' . request()->old_phone . ',phone',
            'role'          => 'required|exists:roles,name',
            'city_id'       => 'required|exists:cities,id',
            'status'        => '',
            'has_residence' => '',
            'gender'        => 'required',
            'birthday'      => '',
            'details'       => '',
            'points'        => 'nullable|numeric',
            'profile'       => 'sometimes|nullable|image|mimes:png,jpg,jpeg',
            'fcm_token'     => '',
        ];
    }
    public function getAddPointsRules()
    {
        return [
            'points' => 'required|numeric',

        ];
    }
}

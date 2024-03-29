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
            'store'            =>  $this->getCreateRules(),
            'update'           =>  $this->getUpdateRules(),
            'updateProfileDashboard' =>  $this->updateProfileDashboardRules(),
            'generateOTP'      =>  $this->generateOTP(),
            'verifyOTP'        =>  $this->verifyOTP(),
            'resetPassword'    =>  $this->resetPassword(),
            'changePassword'   =>  $this->changePassword(),
            'updateProfile'    =>  $this->getUpdateProfileRules(),
            'register'         =>  $this->getRegisterRules(),
            'providerRegister' =>  $this->getRegisterRules(),
            'addPoints'        =>  $this->getAddPointsRules(),
            'enableNotification'    =>  $this->getEnableNotificationRules(),
        };
    }

    public function getCreateRules()
    {
        return [
            'name'          => 'required|min:3',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x]).*$/',
            'address'       => '',
            'phone'         => 'required|min:9|max:10|unique:users,phone',
            'role'          => 'required|exists:roles,name',
            'city_id'       => 'required|exists:cities,id',
            'status'        => '',
            'enable_cash'   => '',
            'gender'        => 'required',
            'birthday'      => '',
            'profile'       => 'sometimes|nullable|image|mimes:png,jpg,jpeg',
            'details'       => '',
            'points'        => 'nullable|numeric',
            'fcm_token'     => '',
            'days'          => 'sometimes|array',
            'latitude'      => 'nullable|numeric',
            'longitude'     => 'nullable|numeric',
        ];
    }
    public function getRegisterRules()
    {
        return [
            'name'          => 'required|min:3',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x]).*$/',
            'address'       => '',
            'phone'         => 'required|min:9|max:10|unique:users,phone',
            'city_id'       => 'required|exists:cities,id',
            'gender'        => 'required',
            'birthday'      => '',
            'profile'       => 'sometimes|nullable|image|mimes:png,jpg,jpeg',
            'details'       => '',
            'points'        => 'nullable|numeric',
            'fcm_token'     => '',
            'latitude'      => 'nullable|numeric',
            'longitude'     => 'nullable|numeric',
            'days'          => 'sometimes|array',
        ];
    }

    public function getUpdateRules()
    {
        return [
            'name'                 => 'required|min:3',
            'email'                => 'required|email|unique:users,email,' . request()->old_email . ',email',
            'password'             => 'nullable|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x]).*$/',
            'address'              => '',
            // 'phone'                => 'sometimes|required|min:9|max:10|unique:users,phone,' . request()->old_phone . ',phone',
            'role'                 => 'required|exists:roles,name',
            'city_id'              => 'required|exists:cities,id',
            'status'               => 'nullable|boolean',
            'enable_cash'          => 'nullable|boolean',
            'gender'               => 'required',
            'birthday'             => 'sometimes|date',
            'details'              => '',
            'profile'              => 'nullable|image|mimes:png,jpg,jpeg',
            'fcm_token'            => '',
            'confirm_password'     => 'sometimes|same:password',
            'days'                 => 'sometimes|array',
            'latitude'             => 'nullable|numeric',
            'longitude'            => 'nullable|numeric',
        ];
    }

    public function updateProfileDashboardRules()
    {
        return [
            'name'                 => 'required|min:3',
            'email'                => 'required|email|unique:users,email,' . request()->old_email . ',email',
            'password'             => 'nullable|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x]).*$/',
            'address'              => '',
            'phone'                => 'sometimes|required|min:9|max:10|unique:users,phone,' . request()->old_phone . ',phone',
            'role'                 => 'required|exists:roles,name',
            'city_id'              => 'required|exists:cities,id',
            'status'               => 'sometimes|required|boolean',
            'gender'               => 'required',
            'birthday'             => 'sometimes|date',
            'details'              => '',
            'profile'              => 'nullable|image|mimes:png,jpg,jpeg',
            'fcm_token'            => '',
            // 'confirm_password'     => 'sometimes|same:password',
            'days'                 => 'sometimes|array',
            'latitude'             => 'nullable|numeric',
            'longitude'            => 'nullable|numeric',
        ];
    }

    public function getUpdateProfileRules()
    {
        return [
            'name'                 => 'required|min:3',
            'email'                => 'required|email|unique:users,email,' . auth()->id(),
            // 'password'             => 'nullable|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x]).*$/',
            'address'              => '',
            // 'phone'                => 'sometimes|required|min:9|max:10|unique:users,phone,' . request()->old_phone . ',phone',
            'city_id'              => 'required|exists:cities,id',
            'gender'               => 'required',
            'birthday'             => 'sometimes|date',
            'details'              => '',
            'profile'              => 'sometimes|image|mimes:png,jpg,jpeg',
            // 'fcm_token'            => '',
            // 'confirm_password'     => 'sometimes|same:password',
            'latitude'             => 'nullable|numeric',
            'longitude'            => 'nullable|numeric',
            'enable_cash'          => 'nullable',
            'days'                 => 'sometimes|array',
        ];
    }

    public function generateOTP()
    {
        if (request()->is_register == 1) {
            return [
                'phone'       => 'required|min:9|max:10|unique:users,phone',
                'is_register' => '',
            ];
        } else {
            return [
                'phone'       => 'required|min:9|max:10|exists:users,phone',
                'is_register' => '',

            ];
        }
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
            'phone'    => 'required|exists:users,phone',
            'password' => 'required|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x]).*$/',
        ];
    }

    public function changePassword()
    {
        return [
            'old_password' => 'required',
            'new_password' => 'required|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x]).*$/',
        ];
    }

    public function getAddPointsRules()
    {
        return [
            'points' => 'required|numeric',
        ];
    }

    public function getEnableNotificationRules()
    {
        return [
            'enable_notification' => 'required|in:0,1',
        ];
    }
}

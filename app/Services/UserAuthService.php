<?php

namespace App\Services;

use App\Models\OTP;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Traits\ModelHelper;
use Exception;

class UserAuthService
{
    use ModelHelper;

    public function __construct(private UserService $userService)
    {
    }

    public function login($validatedData)
    {
        $user = User::where('phone', $validatedData['phone'])->first();

        if (!$user) {
            throw new Exception(__('messages.credentialsError'), 401);
        }
        if ($user->accepted == 0) {
            throw new Exception(__('messages.UnacceptedUser'), 401);
        }
        if ($user->status == 0) {
            throw new Exception(__('messages.blockedUser'), 401);
        }
        $attemptedData = [
            'phone'    => $user->phone,
            'password' => $validatedData['password']
        ];
        if (!Auth::attempt($attemptedData)) {
            throw new Exception(__('messages.incorrect_password'), 401);
        }
        $token = Auth::attempt($attemptedData);
        $user->fcm_token = $validatedData['fcm_token'];
        $user->save();
        
        $accessToken = $user->createToken('auth');

        return [
            'user' => $user,
            'token' => $accessToken->plainTextToken
        ];
    }

    public function changePassword($validatedData)
    {
        // $auth = Auth::guard('sanctum')->user();
        $user = User::where('id',  Auth::user()->id)->first();

        $attemptedData = [
            'phone'    => $user->phone,
            'password' => $validatedData['old_password']
        ];
        // if (!Auth::attempt($attemptedData)) {
        if (!Hash::check($validatedData['old_password'], $user->password)) {
            throw new Exception(__('messages.incorrect_password'), 401);
        }
        DB::beginTransaction();

        $user->update(['password' => Hash::make($validatedData['new_password'])]);

        DB::commit();
    }

    public function logout()
    {
        Auth::guard('user')->logout();
    }

    public function generateOTP($validatedData)
    {
        $user = User::where('phone', $validatedData['phone'])->first();
        $otp = OTP::where('phone', $validatedData['phone'])
            ->first();
        if (isset($otp)) {
            $otp->delete();
        }
        // if (isset($user)) {
        $data = [
            'phone' =>  $validatedData['phone'],
            'otp' => random_int(100000, 999999),
        ];
        $otp = OTP::create($data);
        return $otp;
        // }
        // throw new Exception(__('messages.userNotFound'), 403);
    }
    public function verifyOTP($validatedData)
    {
        $otp = OTP::where('otp', $validatedData['otp'])
            ->where('phone', $validatedData['phone'])
            ->first();
        if (isset($otp)) {
            return $otp;
        }
        throw new Exception(__('messages.invalid_otp'), 403);
    }
    public function resetPassword($validatedData)
    {
        $user = User::where('phone', $validatedData['phone']);
        if (!isset($user)) {
            throw new Exception(__('messages.userNotFound'), 403);
        }
        $user->update([
            'password' => Hash::make($validatedData['password'])
        ]);
        return $user;
    }
    public function updateProfile($validatedData)
    {
        $user = Auth::guard('sanctum')->user();
        $user = User::findOrFail($user->id);
        if (!isset($user)) {
            throw new Exception(__('messages.userNotFound'), 403);
        }
        $user->update($validatedData);

        if (!isset($validatedData['days']))
            $validatedData['days'] = [];
        $user->days()->sync($validatedData['days']);
        return $user;
    }
    public function register($validatedData)
    {
        DB::beginTransaction();

        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['accepted'] = 1;
        $validatedData['status']   = 1;
        $validatedData['role']     = 'user';
        $user = User::create($validatedData);

        $user->assignRole($validatedData['role']);
        DB::commit();
        $accessToken = $user->createToken('auth');
        return [
            'user' => $user,
            'token' => $accessToken->plainTextToken
        ];
    }

    public function providerRegister($validatedData)
    {
        DB::beginTransaction();

        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['status']   = 0;
        $validatedData['accepted'] = 0;
        $validatedData['role'] = 'provider';

        $user = User::create($validatedData);

        if (!isset($validatedData['days']))
            $validatedData['days'] = [];
        $user->days()->sync($validatedData['days']);


        $user->assignRole('provider');

        DB::commit();

        return true;
    }

    public function enableNotification($validatedData)
    {
        $user = User::where('id', Auth::user()->id)->first();

        DB::beginTransaction();

        $user->enable_notification = $validatedData['enable_notification'];
        $user->save();

        DB::commit();

        return $user;
    }
}

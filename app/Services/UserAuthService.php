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
        if ($user->status == 0) {
            throw new Exception(__('messages.blockedUser'), 401);
        }
        $attemptedData = [
            'phone'    => $user->phone,
            'password' => $validatedData['password']
        ];
        if (!Auth::attempt($attemptedData)) {
            throw new Exception(__('messages.incorrectPassword'), 401);
        }
        $token = Auth::attempt($attemptedData);
        $accessToken = $user->createToken('auth');
        return [
            'user' => $user,
            'token' => $accessToken->plainTextToken
        ];
    }

    public function changePassword($validatedData)
    {
        /**
         * @var $user=App\Models\Employee
         */
        $user = Auth::guard('user')->user();

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
        if (isset($user)) {
            $data = [
                'phone' => $user->phone,
                'otp' => random_int(100000, 999999),
            ];
            $otp = OTP::create($data);
            return $otp;
        }
        throw new Exception(__('messages.userNotFound'), 403);
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
        return $user;
    }
    public function register($validatedData)
    {
       return $this->userService->store($validatedData);
    }
}

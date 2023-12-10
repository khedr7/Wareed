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
            throw new Exception(__('messages.incorrect_password'), 401);
        }
        $token = Auth::attempt($attemptedData);
        $accessToken = $user->createToken('auth');
        return [
            'user'  => $user,
            'token' => $accessToken->plainTextToken
        ];
    }

    public function changePassword($validatedData)
    {
        /**
         * @var $user=App\Models\Employee
         */
        $user = Auth::guard('sanctum')->user();

        DB::beginTransaction();

        $user->update(['password' => Hash::make($validatedData['new_password'])]);

        DB::commit();
    }

    public function logout()
    {
        return Auth::guard('sanctum')->user()->currentAccessToken()->delete();
    }

    public function generateOTP($validatedData)
    {
        if (isset($validatedData['is_register'])) {
            if ($validatedData['is_register'] == 1) {
                $otp = OTP::where('phone', $validatedData['phone'])
                    ->first();
                if (isset($otp)) {
                    $otp->delete();
                }
                $data = [
                    'phone' => $validatedData['phone'],
                    'otp' => random_int(100000, 999999),
                ];
                $otp = OTP::create($data);
                return $otp;
            } else {
                $user = User::where('phone', $validatedData['phone'])->first();
                $otp = OTP::where('phone', $validatedData['phone'])
                    ->first();
                if (isset($otp)) {
                    $otp->delete();
                }
                if (isset($user)) {
                    $data = [
                        'phone' => $validatedData['phone'],
                        'otp' => random_int(100000, 999999),
                    ];
                    $otp = OTP::create($data);
                    return $otp;
                }
                throw new Exception(__('messages.userNotFound'), 403);
            }
        }
        $user = User::where('phone', $validatedData['phone'])->first();
        $otp = OTP::where('phone', $validatedData['phone'])
            ->first();
        if (isset($otp)) {
            $otp->delete();
        }
        if (isset($user)) {
            $data = [
                'phone' => $validatedData['phone'],
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

        DB::beginTransaction();

        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['status']   = 1;
        $validatedData['accepted'] = 1;
        $validatedData['role'] = 'user';

        $user = User::create($validatedData);

        $user->assignRole('user');
        $accessToken = $user->createToken('auth');

        DB::commit();

        return [
            'user'  => $user,
            'token' => $accessToken->plainTextToken
        ];
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserAuthRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserAuthService;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserAuthController extends Controller
{
    public function __construct(
        private UserAuthService $userAuthService,
        private UserService $userService
    ) {
    }

    public function login(Request $request)
    {

        $validatedData = $request->validate([
            'phone'    => 'required',
            'password' => 'required',
        ]);
        $details = $this->userAuthService->login($validatedData);
        $details['user'] = UserResource::make($details['user']);
        return $this->successResponse($details, 'userSuccessfullySignedIn', 200);
    }

    public function changePassword(UserRequest $request)
    {
        $validatedData = $request->validated();
        $this->userAuthService->changePassword($validatedData);
        return $this->successResponse(null, 'passwordChangedSuccessfully');
    }

    public function getProfileDetails()
    {
        $user = Auth::guard('user')->user();
        return $this->successResponse(
            $this->resource($user, UserResource::class),
            'dataFetchedSuccessfully'
        );
    }

    public function logout()
    {
        $this->userAuthService->logout();
        return $this->successResponse(
            null,
            'userSuccessfullySignedOut'
        );
    }

    public function generateOTP(UserRequest $request)
    {
        $validatedData = $request->validated();
        $details = $this->userAuthService->generateOTP($validatedData);
        return $this->successResponse($details, 'dataCreatedSuccessfully', 200);
    }

    public function verifyOTP(UserRequest $request)
    {
        $validatedData = $request->validated();
        $this->userAuthService->verifyOTP($validatedData);
        return $this->successResponse([],'dataFetchedSuccessfully', 200);
    }

    public function resetPassword(UserRequest $request)
    {
        $validatedData = $request->validated();
        $this->userAuthService->resetPassword($validatedData);
        return $this->successResponse([], 'dataUpdatedSuccessfully', 200);
    }

    public function updateProfile(UserRequest $request)
    {
        $validatedData = $request->validated();
        $data = $this->userAuthService->updateProfile($validatedData);
        $user = UserResource::make($data);
        return $this->successResponse($user, 'dataUpdatedSuccessfully', 200);
    }

    public function register(UserRequest $request)
    {
        $validatedData = $request->validated();
        $details = $this->userAuthService->register($validatedData);
        $details['user'] = UserResource::make($details['user']);
        return $this->successResponse($details, 'userSuccessfullySignedIn', 200);
    }

    public function getAllProviders()
    {
        $providers = $this->userService->getAllProviders();

        return $this->successResponse(
            $this->resource($providers, UserResource::class),
            'dataFetchedSuccessfully'
        );
    }
    public function find($userId)
    {
        $providers = $this->userService->find($userId);

        return $this->successResponse(
            $this->resource($providers, UserResource::class),
            'dataFetchedSuccessfully'
        );
    }
}

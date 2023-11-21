<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function __construct(private UserService $userService)
    {
    }

    public function index(Request $request)
    {
        $users = $this->userService->getAll($request);

        return view('users.index', compact("users"));
    }

    public function create()
    {
        DB::beginTransaction();

        $data = $this->userService->create();
        $roles = $data['roles'];
        $cities = $data['cities'];

        DB::commit();

        return view('users.create', compact("roles", 'cities'));
    }

    public function edit($id)
    {
        DB::beginTransaction();

        $data = $this->userService->edit($id);
        $user = $data['user'];
        $roles = $data['roles'];
        $cities = $data['cities'];

        DB::commit();

        return view('users.edit', compact('user', "roles", 'cities'));
    }

    public function store(UserRequest $request)
    {
        $validatedData = $request->validated();

        $user = $this->userService->store($validatedData);

        if ($request->file('profile') && $request->file('profile')->isValid()) {
            $user->addMedia($request->profile)->toMediaCollection('profile');
        }

        return redirect('users')->with('success', __('messages.dataAddedSuccessfully'));
    }

    public function update(UserRequest $request, $userId)
    {
        $validatedData = $request->validated();

        $user = $this->userService->update($validatedData, $userId);

        if ($request->file('profile') && $request->file('profile')->isValid()) {
            $user->clearMediaCollection('profile');
            $user->addMedia($request->profile)->toMediaCollection('profile');
        }
        return redirect('users')->with('success', __('messages.dataUpdatedSuccessfully'));
    }

    public function status($id)
    {
        $message = $this->userService->status($id);

        return response()->json($message);
    }

    public function delete($userId)
    {
        $this->userService->delete($userId);

        return redirect('users')->with('success', __('messages.dataDeletedSuccessfully'));
    }

    public function bulkDelete(Request $request)
    {
        $validator = Validator::make($request->all(), ['checked' => 'required']);

        if ($validator->fails()) {
            return back()->with('error',  __('messages.Please select field to be deleted.'));
        }

        $this->userService->bulkDelete($request->checked);


        return back()->with('success',  __('messages.dataAddedSuccessfully'));
    }
}

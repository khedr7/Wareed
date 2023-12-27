<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function indexProviders(Request $request)
    {
        $users = $this->userService->indexProviders($request);

        return view('users.providers', compact("users"));
    }

    public function providersReviews(Request $request)
    {
        $users = $this->userService->indexProviders($request);

        return view('reviews.providers', compact("users"));
    }

    public function allReviews(Request $request)
    {
        $reviews = $this->userService->allReviews($request);

        return view('reviews.all', compact("reviews"));
    }
    public function providerReviews($userId)
    {
        $user = $this->userService->providerReviews($userId);
        // dd()
        return view('reviews.index', compact("user"));
    }

    public function providersRequests(Request $request)
    {
        $users = $this->userService->providersRequests($request);

        return view('users.providerRequests', compact("users"));
    }

    public function unacceptedUsers(Request $request)
    {
        $users = $this->userService->unacceptedUsers($request);

        return view('users.index', compact("users"));
    }

    public function create()
    {
        DB::beginTransaction();

        $data   = $this->userService->create();
        $roles  = $data['roles'];
        $cities = $data['cities'];
        $states = $data['states'];
        $days   = $data['days'];

        DB::commit();

        return view('users.create', compact("roles", 'cities', 'states', 'days'));
    }

    public function edit($id)
    {
        DB::beginTransaction();

        $data = $this->userService->edit($id);
        $user = $data['user'];
        $roles = $data['roles'];
        $cities = $data['cities'];
        $states = $data['states'];
        $days   = $data['days'];

        DB::commit();

        return view('users.edit', compact('user', "roles", 'cities', 'states', 'days'));
    }

    public function editProfile()
    {
        DB::beginTransaction();

        $data = $this->userService->edit(Auth::user()->id);
        $user = $data['user'];
        $roles = $data['roles'];
        $cities = $data['cities'];
        $states = $data['states'];
        $days   = $data['days'];
        DB::commit();

        return view('users.editProfile', compact('user', "roles", 'cities', 'states', 'days'));
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

    public function updateProfileDashboard(UserRequest $request, $userId)
    {
        $validatedData = $request->validated();

        $user = $this->userService->update($validatedData, $userId);

        if ($request->file('profile') && $request->file('profile')->isValid()) {
            $user->clearMediaCollection('profile');
            $user->addMedia($request->profile)->toMediaCollection('profile');
        }
        return redirect('users')->with('success', __('messages.dataUpdatedSuccessfully'));
    }

    public function addPoints(UserRequest $request, $userId)
    {
        $validatedData = $request->validated();

        $user = $this->userService->addPoints($validatedData, $userId);

        return redirect('users')->with('success', __('messages.dataUpdatedSuccessfully'));
    }

    public function status($id)
    {
        $message = $this->userService->status($id);

        return response()->json($message);
    }

    public function accept($id)
    {
        $message = $this->userService->accept($id);

        return response()->json($message);
    }

    public function reviewApprove($id)
    {
        $message = $this->userService->reviewApprove($id);

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


        return back()->with('success',  __('messages.dataDeletedSuccessfully'));
    }

    public function deleteReviews($reviewId)
    {
        $this->userService->deleteReviews($reviewId);

        return back()->with('success', __('messages.dataDeletedSuccessfully'));
    }

    public function reviewsBulkDelete(Request $request)
    {
        $validator = Validator::make($request->all(), ['checked' => 'required']);

        if ($validator->fails()) {
            return back()->with('error',  __('messages.Please select field to be deleted.'));
        }

        $this->userService->reviewsBulkDelete($request->checked);


        return back()->with('success',  __('messages.dataDeletedSuccessfully'));
    }
}

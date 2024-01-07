<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotificationRequest;
use App\Http\Resources\NotificationResource;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Validator;

class NotificationController extends Controller
{
    public function __construct(private NotificationService $notificationService)
    {
    }

    public function index()
    {
        $by_admin = 1;
        $notifications = $this->notificationService->getAll($by_admin);

        return view('notifications.index', compact("notifications"));
    }

    public function create()
    {
        return view('notifications.create');
    }

    public function store(NotificationRequest $request)
    {
        $validatedData = $request->validated();
        $notification = $this->notificationService->create($validatedData);

        return redirect('notifications')->with('success', __('messages.dataAddedSuccessfully'));
    }


    public function update(NotificationRequest $request, $notificationId)
    {
        $validatedData = $request->validated();
        $this->notificationService->update($validatedData, $notificationId);

        return $this->successResponse(
            null,
            'dataUpdatedSuccessfully'
        );
    }

    public function delete($notificationId)
    {
        $this->notificationService->delete($notificationId);

        return redirect('notifications')->with('success', __('messages.dataDeletedSuccessfully'));
    }

    public function bulkDelete(Request $request)
    {
        $validator = Validator::make($request->all(), ['checked' => 'required']);

        if ($validator->fails()) {
            return back()->with('error',  __('messages.Please select field to be deleted.'));
        }

        $this->notificationService->bulkDelete($request->checked);


        return back()->with('success',  __('messages.dataDeletedSuccessfully'));
    }

}

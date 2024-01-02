<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Resources\NotificationResource;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Request;

class NotificationController extends Controller
{
    public function __construct(private NotificationService $notificationService)
    {
    }

    public function userNotification()
    {
        $by_admin = 0;
        $data = $this->notificationService->getAll($by_admin);

        return $this->successResponse(
            $this->resource($data, NotificationResource::class),
            'dataFetchedSuccessfully'
        );
    }

    public function seeAll()
    {
        $data = $this->notificationService->seeAll();

        return $this->successResponse(
            [],
            'dataUpdatedSuccessfully'
        );
    }

    public function unseenCount()
    {
        $data = $this->notificationService->unseenCount();
        return $this->successResponse(
            ['unseen_notifications_count' => $data],
            'dataFetchedSuccessfully'
        );
    }

    public function delete($notificationId)
    {
        $data = $this->notificationService->deleteForUser($notificationId);

        return $this->successResponse(
            [],
            'dataDeletedSuccessfully'
        );
    }

    public function deleteAll()
    {
        $data = $this->notificationService->deleteAllForUser();

        return $this->successResponse(
            [],
            'dataDeletedSuccessfully'
        );
    }
}

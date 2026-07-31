<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\NotificationResource;
use App\Services\NotificationService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    use ResponseTrait;
    public function __construct(
        protected NotificationService $notificationService
    ) {}

    public function index(Request $request)
    {
        $notifications = $this->notificationService->getUserNotifications(
            user: $request->user(),
            perPage: (int) $request->get('per_page', 15)
        );

        return $this->successCollection($notifications, NotificationResource::class);
    }

    public function unreadCount(Request $request)
    {
        $count = $this->notificationService->getUnreadCount($request->user());

        return $this->successResponse(['unread_count' => $count]);
    }

    public function markAsRead(Request $request, string $id)
    {
        $updated = $this->notificationService->markAsRead($request->user(), $id);

        return $this->successResponse([], __('messages.common.updated'));
    }

    public function markAllAsRead(Request $request)
    {
        $this->notificationService->markAllAsRead($request->user());

        return $this->successResponse([], __('messages.common.updated'));
    }
}

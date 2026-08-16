<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\NotificationResource;
use App\Models\Client\Client;
use App\Notifications\BaseNotification;
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

    public function test(int $clientId)
    {
        $client = $clientId
            ? Client::with('user')->find($clientId)
            : Client::with('user')->first();

        if (! $client || ! $client->user) {
            return $this->successResponse([], "Not Found", 404);
        }

        $user = $client->user;

        $user->notify(new BaseNotification(
            title: '🔔 إشعار جديد!',
            body: "أهلاً {$user->first_name}، لقد تمت الموافقة الأولية على طلبك، رجاءً قم بتحديد موعد للمقابلة.",
            data: ['type' => 'test_event', 'client_id' => (string) $client->id],
            actionUrl: '/dashboard'
        ));

        $latestNotification = $user->notifications()->latest()->first();

        return $this->useResource($latestNotification, NotificationResource::class);
    }

    public function testEmployeeNotification(?int $employeeId = null)
    {
        $employee = $employeeId
            ? \App\Models\Core\Employee::with('user')->find($employeeId)
            : \App\Models\Core\Employee::with('user')->first();

        if (! $employee || ! $employee->user) {
            return $this->successResponse([], "Employee or User account Not Found", 404);
        }

        $user = $employee->user;

        $orderNumber = 'ORD-' . date('Y') . '-' . rand(1000, 9999);

        $user->notify(new BaseNotification(
            title: '📦 استلام طلب شراء جديد!',
            body: "مرحباً {$user->full_name}، تم استلام طلب شراء جديد برقم {$orderNumber} بانتظار مراجعتك واتخاذ الإجراء اللازم.",
            data: [
                'type'         => 'new_purchase_order',
                'order_number' => $orderNumber,
                'employee_id'  => (string) $employee->id
            ],
            actionUrl: '/dashboard/orders'
        ));

        $latestNotification = $user->notifications()->latest()->first();

        return $this->useResource($latestNotification, NotificationResource::class);
    }
}

<?php

namespace App\Listeners\V1;

use App\Events\Order\OrderTransferred;
use App\Notifications\BaseNotification;
use App\Models\Core\Employee;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class SendOrderTransferNotification implements ShouldQueue
{
    public function handle(OrderTransferred $event): void
    {
        $order = $event->order;
        $departmentId = $order->department_id;


        $employees = Employee::whereHas('departments', function ($query) use ($departmentId) {
            $query->where('department_id', $departmentId);
        })->get();

        if ($employees->isNotEmpty()) {
            $title = "طلب جديد محول";
            $body = "تم تحويل الطلب رقم #{$order->id} إلى قسمكم.";
            $data = [
                'order_id' => $order->id,
                'type'     => 'order_transfer'
            ];

            Notification::send($employees, new BaseNotification($title, $body, $data));
        }
    }
}

<?php

namespace App\Listeners\V1\Order;

use App\Events\Order\OrderTransferred;
use App\Notifications\BaseNotification;
use App\Models\Core\Employee;
use App\Traits\LocalizesNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendOrderTransferNotification implements ShouldQueue
{
    use LocalizesNotification;

    public function handle(OrderTransferred $event): void
    {
        $order = $event->order;
        $departmentId = $order->department_id;

        $employees = Employee::whereHas('departments', function ($query) use ($departmentId) {
            $query->where('department_id', $departmentId);
        })->get();

        if ($employees->isNotEmpty()) {
            foreach ($employees as $employee) {
                if ($employee->user) {
                    $this->withUserLocale($employee->user, function () use ($order, $employee) {

                        $title = __('notifications.order_transfer_title');
                        $body = __('notifications.order_transfer_body', ['order_id' => $order->id]);

                        $data = [
                            'order_id' => (string) $order->id,
                            'type'     => 'order_transfer'
                        ];

                        $employee->user->notify(new BaseNotification($title, $body, $data));
                    });
                }
            }
        }
    }
}

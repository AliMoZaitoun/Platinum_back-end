<?php

namespace App\Listeners\V1\Order;

use App\Events\Order\OrderCreated;
use App\Notifications\BaseNotification;
use App\Models\User;
use App\Traits\LocalizesNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNewOrderNotification implements ShouldQueue
{
    use LocalizesNotification;

    public function handle(OrderCreated $event): void
    {
        $order = $event->order;
        $employees = User::role('customer_service_staff')->get();

        if ($employees->isNotEmpty()) {
            foreach ($employees as $employee) {
                $this->withUserLocale($employee, function () use ($order, $employee) {

                    $title = __('notifications.new_order_title');
                    $body = __('notifications.new_order_body', ['order_id' => $order->id]);

                    $data = [
                        'order_id' => (string) $order->id,
                        'type'     => 'new_order'
                    ];

                    $employee->notify(new BaseNotification($title, $body, $data, '/dashboard/orders'));
                });
            }
        }
    }
}

<?php

namespace App\Listeners\V1;

use App\Events\Order\OrderCreated;
use App\Notifications\BaseNotification;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class SendNewOrderNotification implements ShouldQueue
{
    public function handle(OrderCreated $event): void
    {
        $order = $event->order;

        $employees = User::role('customer_service_staff')->get();

        if ($employees->isNotEmpty()) {
            $title = "🆕 طلب جديد مستلم!";
            $body = "تم استلام طلب جديد رقم #{$order->id} من العميل، بانتظار المراجعة والموافقة الأولية.";
            $data = [
                'order_id' => (string) $order->id,
                'type'     => 'new_order'
            ];

            Notification::send($employees, new BaseNotification($title, $body, $data, '/dashboard/orders'));
        }
    }
}

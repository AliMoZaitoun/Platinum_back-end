<?php

namespace App\Listeners\Order;

use App\Events\Order\OrderStatusUpdated;
use App\Notifications\BaseNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendOrderStatusNotification implements ShouldQueue
{
    public function handle(OrderStatusUpdated $event): void
    {
        $order = $event->order;
        $client = $order->client;

        if ($client && $client->user) {
            $title = "🔄 تحديث حالة الطلب";
            $body = "تم تحديث حالة طلبك رقم #{$order->id} لتصبح: {$order->status}.";

            $data = [
                'order_id' => (string) $order->id,
                'status'   => $order->status,
                'type'     => 'order_status_updated'
            ];

            $client->user->notify(new BaseNotification($title, $body, $data, '/client/myUnitsOrders'));
        }
    }
}

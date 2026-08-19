<?php

namespace App\Listeners\V1\Complaint;

use App\Events\Complaint\ComplaintStatusUpdated;
use App\Notifications\BaseNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendComplaintStatusNotification implements ShouldQueue
{
    public function handle(ComplaintStatusUpdated $event): void
    {
        $complaint = $event->complaint;
        $client = $complaint->client;

        if ($client && $client->user) {
            $title = "🔄 تحديث حالة الشكوى";
            $body = "تم تحديث حالة الشكوى الخاصة بك '{$complaint->title}' لتصبح: {$complaint->status}.";

            $data = [
                'complaint_id' => (string) $complaint->id,
                'status'       => $complaint->status,
                'type'         => 'complaint_status_updated'
            ];

            $client->user->notify(new BaseNotification($title, $body, $data, '/client/complaints'));
        }
    }
}

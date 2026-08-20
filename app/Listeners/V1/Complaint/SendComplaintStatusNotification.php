<?php

namespace App\Listeners\V1\Complaint;

use App\Events\Complaint\ComplaintStatusUpdated;
use App\Notifications\BaseNotification;
use App\Traits\LocalizesNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendComplaintStatusNotification implements ShouldQueue
{
    use LocalizesNotification;

    public function handle(ComplaintStatusUpdated $event): void
    {
        $complaint = $event->complaint;
        $client = $complaint->client;

        if ($client && $client->user) {
            $this->withUserLocale($client->user, function () use ($complaint, $client) {

                $title = __('notifications.complaint_status_title');
                $body = __('notifications.complaint_status_body', [
                    'title'  => $complaint->title,
                    'status' => $complaint->status,
                ]);

                $data = [
                    'complaint_id' => (string) $complaint->id,
                    'status'       => $complaint->status,
                    'type'         => 'complaint_status_updated'
                ];

                $client->user->notify(new BaseNotification($title, $body, $data, '/client/complaints'));
            });
        }
    }
}

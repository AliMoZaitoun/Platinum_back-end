<?php

namespace App\Listeners\V1\Complaint;

use App\Events\Complaint\ComplaintCreated;
use App\Notifications\BaseNotification;
use App\Models\User;
use App\Traits\LocalizesNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNewComplaintNotification implements ShouldQueue
{
    use LocalizesNotification;

    public function handle(ComplaintCreated $event): void
    {
        $complaint = $event->complaint;
        $employees = User::role('customer_service_staff')->get();

        if ($employees->isNotEmpty()) {
            foreach ($employees as $employee) {
                $this->withUserLocale($employee, function () use ($complaint, $employee) {

                    $title = __('notifications.new_complaint_title');
                    $body = __('notifications.new_complaint_body', [
                        'title' => $complaint->title
                    ]);

                    $data = [
                        'complaint_id' => (string) $complaint->id,
                        'type'         => 'new_complaint'
                    ];

                    $employee->notify(new BaseNotification($title, $body, $data, '/complaint'));
                });
            }
        }
    }
}

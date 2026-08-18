<?php

namespace App\Listeners\Complaint;

use App\Events\Complaint\ComplaintCreated;
use App\Notifications\BaseNotification;
use App\Models\Core\Employee;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class SendNewComplaintNotification implements ShouldQueue
{
    public function handle(ComplaintCreated $event): void
    {
        $complaint = $event->complaint;

        $employees = User::role('customer_service_staff')->get();

        if ($employees->isNotEmpty()) {
            $title = "🚨 شكوى جديدة مستلمة!";
            $body = "تم استلام شكوى جديدة بعنوان '{$complaint->title}'، يرجى المتابعة والرد.";
            $data = [
                'complaint_id' => (string) $complaint->id,
                'type'         => 'new_complaint'
            ];

            Notification::send($employees, new BaseNotification($title, $body, $data, '/complaint'));
        }
    }
}

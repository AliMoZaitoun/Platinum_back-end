<?php

namespace App\Events\Complaint;

use App\Models\Sales\Complaint; // تأكد من مسار الموديل لديك
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ComplaintCreated
{
    use Dispatchable, SerializesModels;

    public function __construct(public Complaint $complaint) {}
}

<?php

namespace App\Listeners\V1;

use App\Events\V1\OTPEvent;
use App\Mail\V1\OtpMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendOtpCodeListener
{
    use InteractsWithQueue;
    public function handle(OTPEvent $event): void
    {
        $email = $event->email;
        $code = $event->code;

        Mail::to($email)->send(new OtpMail($code));
    }
}

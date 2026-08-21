<?php

namespace App\Events\Finance;

use App\Models\Finance\Payment;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PaymentStatusChanged
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public Payment $payment,
        public string $statusType
    ) {}
}

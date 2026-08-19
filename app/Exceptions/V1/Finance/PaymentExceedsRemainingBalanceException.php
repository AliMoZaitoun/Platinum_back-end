<?php

namespace App\Exceptions\V1\Finance;

use Exception;

class PaymentExceedsRemainingBalanceException extends Exception
{
    /**
     * @param float|string $paidAmount
     * @param float|string $totalPendingAmount
     */
    public function __construct($paidAmount, $totalPendingAmount)
    {
        $message = __('messages.payment.exceeds_remaining_balance', [
            'paid_amount' => $paidAmount,
            'total_pending_amount' => $totalPendingAmount
        ]);

        parent::__construct($message, 422);
    }
}

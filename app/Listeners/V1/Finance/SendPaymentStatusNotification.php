<?php

namespace App\Listeners\V1\Finance;

use App\Events\Finance\PaymentStatusChanged;
use App\Models\Core\Employee;
use App\Models\User;
use App\Notifications\BaseNotification;
use App\Traits\LocalizesNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPaymentStatusNotification implements ShouldQueue
{
    use LocalizesNotification;

    public function handle(PaymentStatusChanged $event): void
    {
        $payment = $event->payment;
        $statusType = $event->statusType;
        $client = $payment->client;

        if ($statusType === 'uploaded') {
            $financeUsers = User::role('finance_staff')->get();

            foreach ($financeUsers as $user) {
                $this->withUserLocale($user, function () use ($payment, $client, $user) {
                    $title = __('notifications.payment_uploaded_title');
                    $body = __('notifications.payment_uploaded_body', [
                        'client' => $client->account->full_name ?? 'Client',
                        'amount' => $payment->amount,
                    ]);
                    $data = ['payment_id' => (string) $payment->id, 'type' => 'payment_uploaded'];

                    $user->notify(new BaseNotification($title, $body, $data, '/payment'));
                });
            }
        }

        if (in_array($statusType, ['approved', 'rejected']) && $client && $client->user) {
            $this->withUserLocale($client->user, function () use ($payment, $statusType, $client) {
                if ($statusType === 'approved') {
                    $title = __('notifications.payment_approved_title');
                    $body = __('notifications.payment_approved_body', ['amount' => $payment->amount]);
                } else {
                    $title = __('notifications.payment_rejected_title');
                    $body = __('notifications.payment_rejected_body', ['amount' => $payment->amount]);
                }

                $data = [
                    'payment_id' => (string) $payment->id,
                    'status'     => $statusType,
                    'type'       => 'payment_status_update'
                ];

                $client->user->notify(new BaseNotification($title, $body, $data, '/client/payment'));
            });
        }
    }
}

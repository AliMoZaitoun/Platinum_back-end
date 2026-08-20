<?php

namespace App\Listeners\V1\Finance;

use App\Events\Finance\PaymentOverdue;
use App\Notifications\BaseNotification;
use App\Traits\LocalizesNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPaymentOverdueNotification implements ShouldQueue
{
    use LocalizesNotification;

    public function handle(PaymentOverdue $event): void
    {
        $payment = $event->payment;
        $client = $payment->client;

        if ($client && $client->user) {
            $this->withUserLocale($client->user, function () use ($payment, $client) {
                $title = __('notifications.overdue_client_title');
                $body = __('notifications.overdue_client_body', [
                    'date'     => $payment->payment_date,
                    'amount'   => $payment->amount,
                    'contract' => $payment->contract_id,
                ]);

                $data = [
                    'payment_id'  => (string) $payment->id,
                    'contract_id' => (string) $payment->contract_id,
                    'amount'      => (string) $payment->amount,
                    'type'        => 'payment_overdue'
                ];

                $client->user->notify(new BaseNotification($title, $body, $data, '/client/payment'));
            });
        }

        $employee = $payment->employee;
        if ($employee && $employee->user) {
            $this->withUserLocale($employee->user, function () use ($payment, $client, $employee) {
                $title = __('notifications.overdue_employee_title');
                $body = __('notifications.overdue_employee_body', [
                    'name'     => $client->account->full_name ?? __('notifications.unknown_client'),
                    'contract' => $payment->contract_id,
                ]);

                $data = [
                    'payment_id'  => (string) $payment->id,
                    'contract_id' => (string) $payment->contract_id,
                    'amount'      => (string) $payment->amount,
                    'type'        => 'payment_overdue'
                ];

                $employee->user->notify(new BaseNotification($title, $body, $data, '/payment'));
            });
        }
    }
}

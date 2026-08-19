<?php

namespace App\Listeners\Finance;

use App\Events\Finance\PaymentOverdue;
use App\Notifications\BaseNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPaymentOverdueNotification implements ShouldQueue
{
    public function handle(PaymentOverdue $event): void
    {
        $payment = $event->payment;
        $client = $payment->client;

        if ($client && $client->user) {
            $title = "⚠️ تنبيه تأخير سداد";
            $body = "نود تذكيركم بأن الدفعة المستحقة بتاريخ {$payment->payment_date} بقيمة {$payment->amount} لم يتم سدادها بعد للعقد رقم #{$payment->contract_id}.";

            $data = [
                'payment_id'  => (string) $payment->id,
                'contract_id' => (string) $payment->contract_id,
                'amount'      => (string) $payment->amount,
                'type'        => 'payment_overdue'
            ];

            // إرسال الإشعار للعميل
            $client->user->notify(new BaseNotification($title, $body, $data, '/client/my-payments'));
        }

        // فيك تعمل نفس الشرط لترسل للموظف المسؤول كمان
        $employee = $payment->employee;
        if ($employee && $employee->user) {
            $employee->user->notify(new BaseNotification(
                "دفعة متأخرة لعميل",
                "العميل {$client->account->full_name} لديه دفعة متأخرة.",
                $data,
                '/employee/payments'
            ));
        }
    }
}

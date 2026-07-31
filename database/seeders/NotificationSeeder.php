<?php

namespace Database\Seeders;

use App\Models\Client\Client;
use App\Notifications\BaseNotification;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        $clients = Client::with('user')->get();

        foreach ($clients as $client) {
            if (! $client->user) {
                continue;
            }

            $user = $client->user;

            $user->notify(new BaseNotification(
                title: 'تم قبول طلبك المبدئي 📄',
                body: 'عزيزي ' . $user->first_name . '، تم قبول طلبك المبدئي للشقة. يرجى حجز موعد للمقابلة القانونية.',
                data: ['type' => 'order_initially_accepted'],
                actionUrl: '/appointments/book'
            ));

            $user->notify(new BaseNotification(
                title: 'تأكيد موعد المقابلة 📅',
                body: 'تم تحديد موعد المقابلة القانونية بنجاح. ننتظرك في المقر الرئيسي.',
                data: ['type' => 'appointment_confirmed'],
                actionUrl: '/appointments'
            ));

            $user->notify(new BaseNotification(
                title: 'العقد جاهز للتوقيع والاطلاع 🖋️',
                body: 'تم إصدار عقد البيع الخاص بك، وتم تسجيل استلام الدفعة الأولى بنجاح.',
                data: ['type' => 'contract_active'],
                actionUrl: '/contracts'
            ));
        }
    }
}

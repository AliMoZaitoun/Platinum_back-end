<?php

namespace Database\Seeders;

use App\Models\Client\Client;
use App\Models\Legal\Contract;
use App\Notifications\BaseNotification;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        $clients = Client::with(['user', 'contracts'])->get();

        foreach ($clients as $client) {
            $user = $client->user;

            if (! $user) {
                continue;
            }

            $user->notify(new BaseNotification(
                title: 'مرحباً بك في منصتنا العقارية 👋',
                body: "أهلاً بك يا {$user->first_name}! يسعدنا انضمامك معنا، يمكنك تصفح المشاريع والشقق المتاحة الآن.",
                data: ['type' => 'welcome_message'],
                actionUrl: '/projects'
            ));

            $hasActiveContract = Contract::where('client_id', $client->id)
                ->where('status', 'active')
                ->exists();

            if ($hasActiveContract) {
                $user->notify(new BaseNotification(
                    title: 'تم اعتماد العقد واستلام الدفعة الأولى 📑✅',
                    body: "عزيزي {$user->first_name}، تم توثيق عقد الشراء الخاص بك واستلام السند المالي بنجاح.",
                    data: ['type' => 'contract_active', 'client_id' => $client->id],
                    actionUrl: '/my-contracts'
                ));

                $user->notify(new BaseNotification(
                    title: 'مبروك! تم نقل ملكية الشقة باسمك 🔑🏡',
                    body: 'تم تسجيل الشقة في سجل العقارات الخاص بك بنجاح. يمكنك الاطلاع على التفاصيل من شاشة أملاكي.',
                    data: ['type' => 'unit_owned'],
                    actionUrl: '/my-properties'
                ));
            } else {
                $user->notify(new BaseNotification(
                    title: 'طلبك قيد المراجعة والتدقيق ⏳',
                    body: 'يقوم فريق خدمة العملاء بمراجعة طلبك الحالي وسيتم التواصل معك فور تحديد موعد المقابلة.',
                    data: ['type' => 'order_pending'],
                    actionUrl: '/my-orders'
                ));
            }
        }
    }
}

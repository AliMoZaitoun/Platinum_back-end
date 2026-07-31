<?php

namespace Database\Seeders;

use App\Models\Client\Client;
use App\Models\Core\Employee;
use App\Models\Sales\Appointment;
use App\Models\Sales\AvailabilitySlot;
use App\Models\Sales\Order;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        $clients = Client::all();
        $employees = Employee::all();
        $availableSlots = AvailabilitySlot::all();

        if ($clients->isEmpty() || $availableSlots->isEmpty()) {
            return;
        }

        $statuses = ['pending', 'done', 'cancelled'];

        foreach ($clients as $client) {
            // فحص هل لدى العميل طلب شراء شقة (Order)؟
            $order = Order::where('client_id', $client->id)->first();

            if ($order) {
                // إذا وجد طلب شراء -> الموعد مبيعات sales وينربط بالطلب
                $type = 'sales';
                $orderId = $order->id;
            } else {
                // غير ذلك -> نوع متنوع (عام أو مناقشة قانونية) بدون طلب شراء
                $type = collect(['general', 'legal_discussion'])->random();
                $orderId = null;
            }

            // اختيار موظف للإنشاء (created_by) وسلوت متاح عشوائي
            $creator = $employees->isNotEmpty() ? $employees->random() : $client;
            $slot = $availableSlots->random();

            Appointment::create([
                'order_id'        => $orderId,
                'client_id'       => $client->id,
                'created_by_type' => get_class($creator),
                'created_by_id'   => $creator->id,
                'av_slot_id'      => $slot->id,
                'type'            => $type,
                'status'          => collect($statuses)->random(),
            ]);
        }
    }
}

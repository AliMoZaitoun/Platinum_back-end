<?php

namespace Database\Seeders;

use App\Enums\AppointmentType;
use App\Models\Core\Employee;
use App\Models\Sales\Appointment;
use App\Models\Sales\AvailabilitySlot;
use App\Models\Sales\Order;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        $orders = Order::whereIn('status', ['initially_accepted', 'accepted'])->get();
        $slots = AvailabilitySlot::where('status', 'available')->get();

        $csEmployee = Employee::whereHas('user', function ($query) {
            $query->role('customer_service_staff');
        })->first() ?? Employee::first();

        foreach ($orders as $index => $order) {
            $slot = $slots->get($index);

            if (! $slot) {
                break;
            }

            Appointment::create([
                'order_id'        => $order->id,
                'client_id'       => $order->client_id,
                'created_by_type' => Employee::class,
                'created_by_id'   => $csEmployee->id,
                'av_slot_id'      => $slot->id,
                'type'            => AppointmentType::LEGAL_CONSULTATION->value,
                'status'          => $index % 2 === 0 ? 'done' : 'pending',
            ]);

            $slot->update(['status' => 'booked']);
        }
    }
}

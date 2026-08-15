<?php

namespace Database\Seeders;

use App\Models\Core\Employee;
use App\Models\Legal\Contract;
use App\Models\Media;
use App\Models\Sales\Order;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ContractSeeder extends Seeder
{
    public function run(): void
    {
        $orders = Order::where('status', 'accepted')->get();

        $legalEmployee = Employee::whereHas('user', function ($query) {
            $query->role('legal_staff');
        })->first() ?? Employee::first();

        foreach ($orders as $order) {
            $contract = Contract::create([
                'reference_number'   => 'PLA-' . Str::random(5),
                'client_id'          => $order->client_id,
                'employee_id'        => $legalEmployee->id,
                'order_id'           => $order->id,
                'total_price'        => 250000.00,
                'down_payment_amount' => 50000.00,
                'installments_count' => 12,
                'status'             => 'active',
            ]);

            Media::create([
                'uuid'              => (string) Str::uuid(),
                'mediable_id'       => $contract->id,
                'mediable_type'     => Contract::class,
                'path'              => 'contracts/pdf/sample_contract_' . $contract->id . '.pdf',
                'original_name'     => 'legal_contract_signed.pdf',
                'type'              => 'document',
                'custom_properties' => json_encode(['signed' => true]),
                'recorded_at'       => now(),
            ]);
        }
    }
}

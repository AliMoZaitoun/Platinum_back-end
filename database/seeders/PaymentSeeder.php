<?php

namespace Database\Seeders;

use App\Models\Core\Employee;
use App\Models\Finance\Payment;
use App\Models\Legal\Contract;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $contracts = Contract::where('status', 'active')->get();

        $financeEmployee = Employee::whereHas('user', function ($query) {
            $query->role('finance_staff');
        })->first() ?? Employee::first();

        foreach ($contracts as $contract) {
            Payment::create([
                'client_id'      => $contract->client_id,
                'employee_id'    => $financeEmployee->id,
                'contract_id'    => $contract->id,
                'amount'         => $contract->down_payment_amount,
                'payment_date'   => now(),
                'payment_method' => 'bank_transfer',
                'payment_type'   => 'down_payment',
                'status'         => 'paid',
            ]);

            Payment::create([
                'client_id'      => $contract->client_id,
                'employee_id'    => $financeEmployee->id,
                'contract_id'    => $contract->id,
                'amount'         => ($contract->total_price - $contract->down_payment_amount) / $contract->installments_count,
                'payment_date'   => now()->addMonth(),
                'payment_method' => 'bank_transfer',
                'payment_type'   => 'installment',
                'status'         => 'pending',
            ]);
        }
    }
}

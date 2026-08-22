<?php

namespace Database\Seeders;

use App\Models\Client\Client;
use App\Models\RealEstate\Unit;
use App\Models\Legal\Contract;
use App\Models\Finance\Payment;
use App\Models\Finance\Transaction;
use App\Models\Sales\UnitOwnership;
use App\Models\Core\Employee;
use App\Enums\TransactionCategory;
use Illuminate\Database\Seeder;

class ContractSeeder extends Seeder
{
    public function run(): void
    {
        $clients = Client::all();
        $units = Unit::where('status', 'available')->limit(5)->get();
        $financeEmployee = Employee::first();

        foreach ($units as $index => $unit) {
            $client = $clients[$index % $clients->count()];

            // 1. إنشاء عقد
            $contract = Contract::factory()->create([
                'client_id' => $client->id,
                'unit_id' => $unit->id,
                'total_price' => $unit->price,
                'down_payment_amount' => $unit->price * 0.20,
                'status' => 'completed',
            ]);

            $unit->update(['status' => 'sold']);

            $payment = Payment::factory()->create([
                'contract_id' => $contract->id,
                'client_id' => $client->id,
                'employee_id' => $financeEmployee->id,
                'amount' => $contract->down_payment_amount,
                'payment_type' => 'down_payment',
                'status' => 'paid',
            ]);

            Transaction::create([
                'type' => 'receipt',
                'amount' => $payment->amount,
                'currency' => 'QAR',
                'exchange_rate' => 1.00,
                'category' => TransactionCategory::DOWN_PAYMENT->value,
                'payment_method' => $payment->payment_method,
                'created_by' => $financeEmployee->id,
                'transactionable_type' => Payment::class,
                'transactionable_id' => $payment->id,
                'party_type' => Client::class,
                'party_id' => $client->id,
                'status' => 'posted',
                'description' => 'تسديد آلي للدفعة الأولى - عقد رقم ' . $contract->id
            ]);

            UnitOwnership::create([
                'client_id' => $client->id,
                'contract_id' => $contract->id,
                'unit_id' => $unit->id,
                'purchase_price' => $contract->total_price,
                'status' => 'transferred',
                'owned_at' => now(),
            ]);
        }
    }
}

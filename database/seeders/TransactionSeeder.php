<?php

namespace Database\Seeders;

use App\Enums\TransactionCategory;
use App\Models\Client\Client;
use App\Models\Core\Employee;
use App\Models\Finance\Payment;
use App\Models\Finance\Transaction;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $paidPayments = Payment::where('status', 'paid')->get();
        $financeEmployee = Employee::whereHas('user', function ($query) {
            $query->role('finance_staff');
        })->first() ?? Employee::first();

        foreach ($paidPayments as $payment) {
            $category = match ($payment->payment_type) {
                'down_payment'     => TransactionCategory::DOWN_PAYMENT->value,
                'installment'      => TransactionCategory::INSTALLMENT->value,
                'final_payment'    => TransactionCategory::FINAL_PAYMENT->value,
                'maintenance_fees' => TransactionCategory::MAINTENANCE_FEES->value,
                default            => TransactionCategory::OTHER->value,
            };

            Transaction::create([
                'voucher_number'       => 'VOUCH-' . strtoupper(bin2hex(random_bytes(4))),
                'type'                 => 'receipt',
                'amount'               => $payment->amount,
                'currency'             => 'USD',
                'exchange_rate'        => 1.0000,
                'transactionable_type' => Payment::class,
                'transactionable_id'   => $payment->id,
                'party_type'           => Client::class,
                'party_id'             => $payment->client_id,
                'category'             => $category,
                'payment_method'       => $payment->payment_method,
                'status'               => 'posted',
                'description'          => 'استلام دفعة مقدمة للعقد رقم #' . $payment->contract_id,
                'created_by'           => $financeEmployee?->id ?? 1,
            ]);
        }
    }
}

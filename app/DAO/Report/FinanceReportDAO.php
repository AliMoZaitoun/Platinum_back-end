<?php

namespace App\DAO\Report;

use App\Models\Finance\Payment;
use App\Models\Finance\Transaction;
use Carbon\Carbon;

class FinanceReportDAO
{
    public function getOverdueStats(): array
    {
        $overdueQuery = Payment::whereIn('status', ['pending', 'failed'])
            ->whereDate('payment_date', '<', Carbon::today());

        return [
            'count' => $overdueQuery->count(),
            'total_amount' => $overdueQuery->sum('amount')
        ];
    }

    public function getMonthlyCashFlow(): array
    {
        $transactions = Transaction::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->where('status', 'posted')
            ->get();

        return [
            'receipts' => $transactions->where('type', 'receipt')->sum('amount'),
            'payments' => $transactions->where('type', 'payment')->sum('amount'),
        ];
    }

    public function getPaymentMethodsStats(): array
    {
        $payments = Payment::where('status', 'paid')
            ->selectRaw('payment_method, count(*) as count, sum(amount) as total')
            ->groupBy('payment_method')
            ->get()
            ->keyBy('payment_method');

        return [
            'cash'           => $payments->get('cash')->total ?? 0,
            'bank_transfer'  => $payments->get('bank_transfer')->total ?? 0,
            'check'          => $payments->get('check')->total ?? 0,
            'card'           => $payments->get('card')->total ?? 0,
        ];
    }
}

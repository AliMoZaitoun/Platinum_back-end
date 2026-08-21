@extends('layouts.report')

@section('report_title')
{{ __('reports.finance_summary') }}
@endsection

@section('content')
<div class="space-y-8">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-rose-100 relative overflow-hidden">
            <div class="flex justify-between items-start mb-4">
                <h2 class="text-sm font-bold text-rose-700 uppercase tracking-wider">{{ __('reports.overdue_payments') }}</h2>
                <span class="px-2.5 py-1 bg-rose-100 text-rose-700 text-xs font-bold rounded-md">{{ $overdue['count'] }} {{ __('reports.overdue_count') }}</span>
            </div>
            <div class="mt-2">
                <span class="text-3xl font-extrabold text-rose-600">${{ number_format($overdue['total_amount'], 2) }}</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
            <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4">{{ __('reports.monthly_cash_flow') }}</h2>
            <div class="space-y-3">
                <div class="flex justify-between items-center p-3 bg-emerald-50/50 rounded-xl border border-emerald-100">
                    <span class="text-sm font-medium text-emerald-900">{{ __('reports.receipts') }}</span>
                    <span class="text-lg font-bold text-emerald-600">+${{ number_format($cash_flow['receipts'], 2) }}</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-rose-50/50 rounded-xl border border-rose-100">
                    <span class="text-sm font-medium text-rose-900">{{ __('reports.payments_out') }}</span>
                    <span class="text-lg font-bold text-rose-600">-${{ number_format($cash_flow['payments'], 2) }}</span>
                </div>
            </div>
        </div>

    </div>

    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
        <h2 class="text-lg font-bold text-slate-900 mb-6">{{ __('reports.payment_methods') }}</h2>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 text-center">
                <span class="block text-xs font-medium text-slate-500 mb-1">{{ __('reports.cash') }}</span>
                <span class="text-lg font-bold text-slate-900">${{ number_format($payment_methods['cash'], 2) }}</span>
            </div>
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 text-center">
                <span class="block text-xs font-medium text-slate-500 mb-1">{{ __('reports.bank_transfer') }}</span>
                <span class="text-lg font-bold text-slate-900">${{ number_format($payment_methods['bank_transfer'], 2) }}</span>
            </div>
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 text-center">
                <span class="block text-xs font-medium text-slate-500 mb-1">{{ __('reports.check') }}</span>
                <span class="text-lg font-bold text-slate-900">${{ number_format($payment_methods['check'], 2) }}</span>
            </div>
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 text-center">
                <span class="block text-xs font-medium text-slate-500 mb-1">{{ __('reports.card') }}</span>
                <span class="text-lg font-bold text-slate-900">${{ number_format($payment_methods['card'], 2) }}</span>
            </div>
        </div>
    </div>

</div>
@endsection
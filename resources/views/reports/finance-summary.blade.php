@extends('reports.layout')

@section('report_title')
{{ __('reports.finance_summary') }}
@endsection

@section('content')
<div class="space-y-5">

    <div class="grid grid-cols-2 gap-4">

        <div class="border border-slate-200 p-4 bg-slate-50/50">
            <div class="flex justify-between items-center border-b border-slate-300 pb-2 mb-3">
                <h2 class="font-bold text-xs uppercase tracking-wider text-rose-700">{{ __('reports.overdue_payments') }}</h2>
                <span class="bg-rose-100 text-rose-800 text-[10px] font-mono px-2 py-0.5 font-bold">
                    {{ $overdue['count'] }} {{ __('reports.overdue_count') }}
                </span>
            </div>
            <div class="mt-2 text-center bg-white p-3 border border-slate-200">
                <span class="font-mono text-3xl font-black text-rose-600">${{ number_format($overdue['total_amount'], 2) }}</span>
            </div>
        </div>

        <div class="border border-slate-200 p-4 bg-slate-50/50">
            <h2 class="font-bold text-xs uppercase tracking-wider text-slate-800 border-b border-slate-300 pb-2 mb-3">{{ __('reports.monthly_cash_flow') }}</h2>
            <div class="space-y-2">
                <div class="flex justify-between items-center p-2 bg-white border border-slate-200 text-xs">
                    <span class="text-slate-600 font-medium">{{ __('reports.receipts') }}</span>
                    <span class="font-mono font-bold text-emerald-600">+${{ number_format($cash_flow['receipts'], 2) }}</span>
                </div>
                <div class="flex justify-between items-center p-2 bg-white border border-slate-200 text-xs">
                    <span class="text-slate-600 font-medium">{{ __('reports.payments_out') }}</span>
                    <span class="font-mono font-bold text-rose-600">-${{ number_format($cash_flow['payments'], 2) }}</span>
                </div>
            </div>
        </div>

    </div>

    <div class="border border-slate-200 p-4 bg-slate-50/50">
        <div class="border-b border-slate-300 pb-2 mb-3 flex justify-between items-center">
            <h2 class="font-bold text-xs uppercase tracking-wider text-slate-800">{{ __('reports.payment_methods') }}</h2>
            <span class="font-mono text-[10px] text-slate-400">REF: FIN-02</span>
        </div>
        <div class="grid grid-cols-4 gap-3">
            <div class="p-3 bg-white border border-slate-200 text-center">
                <span class="block text-[10px] font-mono text-slate-500 uppercase mb-1">{{ __('reports.cash') }}</span>
                <span class="font-mono font-bold text-slate-900">${{ number_format($payment_methods['cash'], 2) }}</span>
            </div>
            <div class="p-3 bg-white border border-slate-200 text-center">
                <span class="block text-[10px] font-mono text-slate-500 uppercase mb-1">{{ __('reports.bank_transfer') }}</span>
                <span class="font-mono font-bold text-slate-900">${{ number_format($payment_methods['bank_transfer'], 2) }}</span>
            </div>
            <div class="p-3 bg-white border border-slate-200 text-center">
                <span class="block text-[10px] font-mono text-slate-500 uppercase mb-1">{{ __('reports.check') }}</span>
                <span class="font-mono font-bold text-slate-900">${{ number_format($payment_methods['check'], 2) }}</span>
            </div>
            <div class="p-3 bg-white border border-slate-200 text-center">
                <span class="block text-[10px] font-mono text-slate-500 uppercase mb-1">{{ __('reports.card') }}</span>
                <span class="font-mono font-bold text-slate-900">${{ number_format($payment_methods['card'], 2) }}</span>
            </div>
        </div>
    </div>

</div>
@endsection
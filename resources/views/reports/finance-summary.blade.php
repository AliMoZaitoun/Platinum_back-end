@extends('reports.layout')

@section('report_title')
{{ __('reports.finance_summary') }}
@endsection

@section('content')
<div class="space-y-8">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div class="border-2 border-slate-900 p-6 bg-white">
            <div class="flex justify-between items-center mb-4 border-b-2 border-slate-900 pb-2">
                <h2 class="font-black text-sm uppercase tracking-wider text-rose-700">{{ __('reports.overdue_payments') }}</h2>
                <span class="border border-rose-900 bg-rose-100 text-rose-900 text-[10px] font-mono px-2 py-0.5 font-bold">
                    {{ $overdue['count'] }} {{ __('reports.overdue_count') }}
                </span>
            </div>
            <div class="mt-4">
                <span class="font-mono text-4xl font-black text-rose-600">${{ number_format($overdue['total_amount'], 2) }}</span>
            </div>
        </div>

        <div class="border-2 border-slate-900 p-6 bg-white">
            <h2 class="font-black text-sm uppercase tracking-wider text-slate-900 mb-4 border-b-2 border-slate-900 pb-2">{{ __('reports.monthly_cash_flow') }}</h2>
            <div class="space-y-3">
                <div class="flex justify-between items-center p-2.5 border border-slate-300 bg-slate-50">
                    <span class="text-xs font-bold text-slate-700">{{ __('reports.receipts') }}</span>
                    <span class="font-mono font-black text-emerald-600 text-base">+${{ number_format($cash_flow['receipts'], 2) }}</span>
                </div>
                <div class="flex justify-between items-center p-2.5 border border-slate-300 bg-slate-50">
                    <span class="text-xs font-bold text-slate-700">{{ __('reports.payments_out') }}</span>
                    <span class="font-mono font-black text-rose-600 text-base">-${{ number_format($cash_flow['payments'], 2) }}</span>
                </div>
            </div>
        </div>

    </div>

    <div class="border-2 border-slate-900 p-6 bg-white">
        <div class="border-b-2 border-slate-900 pb-3 mb-6 flex justify-between items-center">
            <h2 class="font-black text-base uppercase tracking-wider text-slate-900">{{ __('reports.payment_methods') }}</h2>
            <span class="font-mono text-xs text-slate-500">[FIN-02]</span>
        </div>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="p-4 border-2 border-slate-200 bg-slate-50 text-center">
                <span class="block text-[11px] font-mono font-bold text-slate-600 uppercase mb-1">{{ __('reports.cash') }}</span>
                <span class="font-mono font-black text-slate-900 text-lg">${{ number_format($payment_methods['cash'], 2) }}</span>
            </div>
            <div class="p-4 border-2 border-slate-200 bg-slate-50 text-center">
                <span class="block text-[11px] font-mono font-bold text-slate-600 uppercase mb-1">{{ __('reports.bank_transfer') }}</span>
                <span class="font-mono font-black text-slate-900 text-lg">${{ number_format($payment_methods['bank_transfer'], 2) }}</span>
            </div>
            <div class="p-4 border-2 border-slate-200 bg-slate-50 text-center">
                <span class="block text-[11px] font-mono font-bold text-slate-600 uppercase mb-1">{{ __('reports.check') }}</span>
                <span class="font-mono font-black text-slate-900 text-lg">${{ number_format($payment_methods['check'], 2) }}</span>
            </div>
            <div class="p-4 border-2 border-slate-200 bg-slate-50 text-center">
                <span class="block text-[11px] font-mono font-bold text-slate-600 uppercase mb-1">{{ __('reports.card') }}</span>
                <span class="font-mono font-black text-slate-900 text-lg">${{ number_format($payment_methods['card'], 2) }}</span>
            </div>
        </div>
    </div>

</div>
@endsection
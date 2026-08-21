@extends('reports.layout')

@section('report_title')
{{ __('reports.sales_marketing_summary') }}
@endsection

@section('content')
<div class="space-y-5">

    <div class="border border-slate-200 p-4 bg-slate-50/50">
        <div class="border-b border-slate-300 pb-2 mb-3 flex justify-between items-center">
            <h2 class="font-bold text-xs uppercase tracking-wider text-slate-800">{{ __('reports.sales_funnel') }}</h2>
            <span class="font-mono text-[10px] text-slate-400">REF: MKT-01</span>
        </div>
        <div class="grid grid-cols-3 gap-3">
            <div class="p-3 bg-white border border-slate-200 text-center">
                <span class="block text-[10px] font-mono text-slate-500 uppercase mb-1">{{ __('reports.appointments_done') }}</span>
                <span class="font-mono text-2xl font-bold text-blue-600">{{ $funnel['appointments_done'] }}</span>
            </div>
            <div class="p-3 bg-white border border-slate-200 text-center">
                <span class="block text-[10px] font-mono text-slate-500 uppercase mb-1">{{ __('reports.orders_received') }}</span>
                <span class="font-mono text-2xl font-bold text-indigo-600">{{ $funnel['orders_received'] }}</span>
            </div>
            <div class="p-3 bg-white border border-slate-200 text-center">
                <span class="block text-[10px] font-mono text-slate-500 uppercase mb-1">{{ __('reports.orders_accepted') }}</span>
                <span class="font-mono text-2xl font-bold text-emerald-600">{{ $funnel['orders_accepted'] }}</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4">

        <div class="border border-slate-200 p-4 bg-slate-50/50">
            <div class="border-b border-slate-300 pb-2 mb-3 flex justify-between items-center">
                <h2 class="font-bold text-xs uppercase tracking-wider text-slate-800">{{ __('reports.ads_stats') }}</h2>
                <span class="font-mono text-[10px] text-slate-400">REF: MKT-02</span>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between items-center p-2 bg-white border border-slate-200 text-xs">
                    <span class="text-slate-600 font-medium">{{ __('reports.active_ads') }}</span>
                    <span class="font-mono font-bold text-emerald-600">{{ $ads['active'] }}</span>
                </div>
                <div class="flex justify-between items-center p-2 bg-white border border-slate-200 text-xs">
                    <span class="text-slate-600 font-medium">{{ __('reports.total_ads') }}</span>
                    <span class="font-mono font-bold text-slate-900">{{ $ads['total'] }}</span>
                </div>
            </div>
        </div>

        <div class="border border-slate-200 p-4 bg-slate-50/50">
            <div class="border-b border-slate-300 pb-2 mb-3 flex justify-between items-center">
                <h2 class="font-bold text-xs uppercase tracking-wider text-slate-800">{{ __('reports.offers_stats') }}</h2>
                <span class="font-mono text-[10px] text-slate-400">REF: MKT-03</span>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between items-center p-2 bg-white border border-slate-200 text-xs">
                    <span class="text-slate-600 font-medium">{{ __('reports.active_offers') }}</span>
                    <span class="font-mono font-bold text-blue-600">{{ $offers['active'] }}</span>
                </div>
                <div class="flex justify-between items-center p-2 bg-white border border-slate-200 text-xs">
                    <span class="text-slate-600 font-medium">{{ __('reports.avg_discount') }}</span>
                    <span class="font-mono font-bold text-amber-600">%{{ number_format($offers['avg_discount'], 1) }}</span>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
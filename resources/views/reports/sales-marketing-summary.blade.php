@extends('reports.layout')

@section('report_title')
{{ __('reports.sales_marketing_summary') }}
@endsection

@section('content')
<div class="space-y-8">

    <div class="border-2 border-slate-900 p-6 bg-white">
        <div class="border-b-2 border-slate-900 pb-3 mb-6 flex justify-between items-center">
            <h2 class="font-black text-base uppercase tracking-wider text-slate-900">{{ __('reports.sales_funnel') }}</h2>
            <span class="font-mono text-xs text-slate-500">[MKT-01]</span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="p-5 border-2 border-slate-900 bg-slate-50 text-center">
                <span class="block text-xs font-mono font-bold text-slate-600 uppercase mb-2">{{ __('reports.appointments_done') }}</span>
                <span class="font-mono text-3xl font-black text-blue-600">{{ $funnel['appointments_done'] }}</span>
            </div>
            <div class="p-5 border-2 border-slate-900 bg-slate-50 text-center">
                <span class="block text-xs font-mono font-bold text-slate-600 uppercase mb-2">{{ __('reports.orders_received') }}</span>
                <span class="font-mono text-3xl font-black text-indigo-600">{{ $funnel['orders_received'] }}</span>
            </div>
            <div class="p-5 border-2 border-slate-900 bg-slate-50 text-center">
                <span class="block text-xs font-mono font-bold text-slate-600 uppercase mb-2">{{ __('reports.orders_accepted') }}</span>
                <span class="font-mono text-3xl font-black text-emerald-600">{{ $funnel['orders_accepted'] }}</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div class="border-2 border-slate-900 p-6 bg-white">
            <div class="border-b-2 border-slate-900 pb-3 mb-6 flex justify-between items-center">
                <h2 class="font-black text-base uppercase tracking-wider text-slate-900">{{ __('reports.ads_stats') }}</h2>
                <span class="font-mono text-xs text-slate-500">[MKT-02]</span>
            </div>
            <div class="space-y-3">
                <div class="flex justify-between items-center p-3 border border-slate-300 bg-slate-50">
                    <span class="text-xs font-bold text-slate-700">{{ __('reports.active_ads') }}</span>
                    <span class="font-mono font-black text-emerald-600 text-base">{{ $ads['active'] }}</span>
                </div>
                <div class="flex justify-between items-center p-3 border border-slate-300 bg-slate-50">
                    <span class="text-xs font-bold text-slate-700">{{ __('reports.total_ads') }}</span>
                    <span class="font-mono font-black text-slate-900 text-base">{{ $ads['total'] }}</span>
                </div>
            </div>
        </div>

        <div class="border-2 border-slate-900 p-6 bg-white">
            <div class="border-b-2 border-slate-900 pb-3 mb-6 flex justify-between items-center">
                <h2 class="font-black text-base uppercase tracking-wider text-slate-900">{{ __('reports.offers_stats') }}</h2>
                <span class="font-mono text-xs text-slate-500">[MKT-03]</span>
            </div>
            <div class="space-y-3">
                <div class="flex justify-between items-center p-3 border border-slate-300 bg-slate-50">
                    <span class="text-xs font-bold text-slate-700">{{ __('reports.active_offers') }}</span>
                    <span class="font-mono font-black text-blue-600 text-base">{{ $offers['active'] }}</span>
                </div>
                <div class="flex justify-between items-center p-3 border border-slate-300 bg-slate-50">
                    <span class="text-xs font-bold text-slate-700">{{ __('reports.avg_discount') }}</span>
                    <span class="font-mono font-black text-amber-600 text-base">%{{ number_format($offers['avg_discount'], 1) }}</span>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
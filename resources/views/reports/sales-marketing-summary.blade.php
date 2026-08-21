@extends('layouts.report')

@section('report_title')
{{ __('reports.sales_marketing_summary') }}
@endsection

@section('content')
<div class="space-y-8">

    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
        <h2 class="text-lg font-bold text-slate-900 mb-6">{{ __('reports.sales_funnel') }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="p-5 bg-blue-50/50 border border-blue-100 rounded-xl text-center">
                <span class="block text-xs font-semibold text-blue-800 mb-2">{{ __('reports.appointments_done') }}</span>
                <span class="text-3xl font-extrabold text-blue-600">{{ $funnel['appointments_done'] }}</span>
            </div>
            <div class="p-5 bg-indigo-50/50 border border-indigo-100 rounded-xl text-center">
                <span class="block text-xs font-semibold text-indigo-800 mb-2">{{ __('reports.orders_received') }}</span>
                <span class="text-3xl font-extrabold text-indigo-600">{{ $funnel['orders_received'] }}</span>
            </div>
            <div class="p-5 bg-emerald-50/50 border border-emerald-100 rounded-xl text-center">
                <span class="block text-xs font-semibold text-emerald-800 mb-2">{{ __('reports.orders_accepted') }}</span>
                <span class="text-3xl font-extrabold text-emerald-600">{{ $funnel['orders_accepted'] }}</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
            <h2 class="text-lg font-bold text-slate-900 mb-6">{{ __('reports.ads_stats') }}</h2>
            <div class="space-y-3">
                <div class="flex justify-between items-center p-3.5 bg-emerald-50/50 border border-emerald-100 rounded-xl">
                    <span class="text-sm font-medium text-emerald-900">{{ __('reports.active_ads') }}</span>
                    <span class="text-lg font-bold text-emerald-600">{{ $ads['active'] }}</span>
                </div>
                <div class="flex justify-between items-center p-3.5 bg-slate-50 border border-slate-100 rounded-xl">
                    <span class="text-sm font-medium text-slate-700">{{ __('reports.total_ads') }}</span>
                    <span class="text-lg font-bold text-slate-900">{{ $ads['total'] }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
            <h2 class="text-lg font-bold text-slate-900 mb-6">{{ __('reports.offers_stats') }}</h2>
            <div class="space-y-3">
                <div class="flex justify-between items-center p-3.5 bg-blue-50/50 border border-blue-100 rounded-xl">
                    <span class="text-sm font-medium text-blue-900">{{ __('reports.active_offers') }}</span>
                    <span class="text-lg font-bold text-blue-600">{{ $offers['active'] }}</span>
                </div>
                <div class="flex justify-between items-center p-3.5 bg-amber-50/50 border border-amber-100 rounded-xl">
                    <span class="text-sm font-medium text-amber-900">{{ __('reports.avg_discount') }}</span>
                    <span class="text-lg font-bold text-amber-600">%{{ number_format($offers['avg_discount'], 1) }}</span>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
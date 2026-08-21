@extends('layouts.report')

@section('report_title')
{{ __('reports.inventory_summary') }}
@endsection

@section('content')
<div class="space-y-8">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
            <h2 class="text-lg font-bold text-slate-900 mb-6">{{ __('reports.warehouses_overview') }}</h2>
            <div class="space-y-3">
                <div class="flex justify-between items-center p-3.5 bg-blue-50/50 border border-blue-100 rounded-xl">
                    <span class="text-sm font-medium text-blue-900">{{ __('reports.total_warehouses') }}</span>
                    <span class="text-lg font-bold text-blue-600">{{ $warehouses['total_warehouses'] }}</span>
                </div>
                <div class="flex justify-between items-center p-3.5 bg-slate-50 border border-slate-100 rounded-xl">
                    <span class="text-sm font-medium text-slate-700">{{ __('reports.total_items_quantity') }}</span>
                    <span class="text-lg font-bold text-slate-900">{{ number_format($warehouses['total_items']) }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
            <h2 class="text-lg font-bold text-slate-900 mb-6">{{ __('reports.items_status') }}</h2>
            <div class="space-y-3">
                <div class="flex justify-between items-center p-3 bg-emerald-50/50 border border-emerald-100 rounded-xl">
                    <span class="text-sm font-medium text-emerald-900">{{ __('reports.in_stock') }}</span>
                    <span class="text-lg font-bold text-emerald-600">{{ $status['in_stock'] }}</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-rose-50/50 border border-rose-100 rounded-xl">
                    <span class="text-sm font-medium text-rose-900">{{ __('reports.out_of_stock') }}</span>
                    <span class="text-lg font-bold text-rose-600">{{ $status['out_of_stock'] }}</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-slate-50 border border-slate-100 rounded-xl">
                    <span class="text-sm font-medium text-slate-600">{{ __('reports.discontinued') }}</span>
                    <span class="text-lg font-bold text-slate-500">{{ $status['discontinued'] }}</span>
                </div>
            </div>
        </div>

    </div>

    <div class="bg-white rounded-2xl p-6 shadow-sm border border-rose-100">
        <h2 class="text-lg font-bold text-rose-900 mb-6">{{ __('reports.inventory_alerts') }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="p-5 bg-amber-50/60 border border-amber-100 rounded-xl text-center">
                <span class="block text-xs font-semibold text-amber-800 mb-1">{{ __('reports.expiring_soon') }} (30 {{ __('reports.days') }})</span>
                <span class="text-3xl font-extrabold text-amber-600">{{ $alerts['expiring_soon'] }}</span>
            </div>
            <div class="p-5 bg-rose-50/60 border border-rose-100 rounded-xl text-center">
                <span class="block text-xs font-semibold text-rose-800 mb-1">{{ __('reports.expired_items') }}</span>
                <span class="text-3xl font-extrabold text-rose-600">{{ $alerts['expired'] }}</span>
            </div>
        </div>
    </div>

</div>
@endsection
@extends('reports.layout')

@section('report_title')
{{ __('reports.inventory_summary') }}
@endsection

@section('content')
<div class="space-y-8">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div class="border-2 border-slate-900 p-6 bg-white">
            <div class="border-b-2 border-slate-900 pb-3 mb-6 flex justify-between items-center">
                <h2 class="font-black text-base uppercase tracking-wider text-slate-900">{{ __('reports.warehouses_overview') }}</h2>
                <span class="font-mono text-xs text-slate-500">[INV-01]</span>
            </div>
            <div class="space-y-3">
                <div class="flex justify-between items-center p-3 border border-slate-300 bg-slate-50">
                    <span class="text-xs font-bold text-slate-700">{{ __('reports.total_warehouses') }}</span>
                    <span class="font-mono font-black text-blue-600 text-base">{{ $warehouses['total_warehouses'] }}</span>
                </div>
                <div class="flex justify-between items-center p-3 border border-slate-300 bg-slate-50">
                    <span class="text-xs font-bold text-slate-700">{{ __('reports.total_items_quantity') }}</span>
                    <span class="font-mono font-black text-slate-900 text-base">{{ number_format($warehouses['total_items']) }}</span>
                </div>
            </div>
        </div>

        <div class="border-2 border-slate-900 p-6 bg-white">
            <div class="border-b-2 border-slate-900 pb-3 mb-6 flex justify-between items-center">
                <h2 class="font-black text-base uppercase tracking-wider text-slate-900">{{ __('reports.items_status') }}</h2>
                <span class="font-mono text-xs text-slate-500">[INV-02]</span>
            </div>
            <div class="space-y-3">
                <div class="flex justify-between items-center p-2.5 border border-slate-300 bg-slate-50">
                    <span class="text-xs font-bold text-slate-700">{{ __('reports.in_stock') }}</span>
                    <span class="font-mono font-black text-emerald-600 text-base">{{ $status['in_stock'] }}</span>
                </div>
                <div class="flex justify-between items-center p-2.5 border border-slate-300 bg-slate-50">
                    <span class="text-xs font-bold text-slate-700">{{ __('reports.out_of_stock') }}</span>
                    <span class="font-mono font-black text-rose-600 text-base">{{ $status['out_of_stock'] }}</span>
                </div>
                <div class="flex justify-between items-center p-2.5 border border-slate-300 bg-slate-50">
                    <span class="text-xs font-bold text-slate-700">{{ __('reports.discontinued') }}</span>
                    <span class="font-mono font-black text-slate-500 text-base">{{ $status['discontinued'] }}</span>
                </div>
            </div>
        </div>

    </div>

    <div class="border-2 border-slate-900 p-6 bg-white">
        <div class="border-b-2 border-slate-900 pb-3 mb-6 flex justify-between items-center">
            <h2 class="font-black text-base uppercase tracking-wider text-rose-700">{{ __('reports.inventory_alerts') }}</h2>
            <span class="font-mono text-xs text-slate-500">[INV-WARN]</span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="p-5 border-2 border-slate-900 bg-amber-50 text-center">
                <span class="block text-xs font-mono font-bold text-slate-700 uppercase mb-2">{{ __('reports.expiring_soon') }}</span>
                <span class="font-mono text-4xl font-black text-amber-600">{{ $alerts['expiring_soon'] }}</span>
            </div>
            <div class="p-5 border-2 border-slate-900 bg-rose-50 text-center">
                <span class="block text-xs font-mono font-bold text-slate-700 uppercase mb-2">{{ __('reports.expired_items') }}</span>
                <span class="font-mono text-4xl font-black text-rose-600">{{ $alerts['expired'] }}</span>
            </div>
        </div>
    </div>

</div>
@endsection
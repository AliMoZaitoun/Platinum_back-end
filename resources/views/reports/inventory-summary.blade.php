@extends('reports.layout')

@section('report_title')
{{ __('reports.inventory_summary') }}
@endsection

@section('content')
<div class="space-y-5">

    <div class="grid grid-cols-2 gap-4">

        <div class="border border-slate-200 p-4 bg-slate-50/50">
            <div class="border-b border-slate-300 pb-2 mb-3 flex justify-between items-center">
                <h2 class="font-bold text-xs uppercase tracking-wider text-slate-800">{{ __('reports.warehouses_overview') }}</h2>
                <span class="font-mono text-[10px] text-slate-400">REF: INV-01</span>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between items-center p-2 bg-white border border-slate-200 text-xs">
                    <span class="text-slate-600 font-medium">{{ __('reports.total_warehouses') }}</span>
                    <span class="font-mono font-bold text-blue-600">{{ $warehouses['total_warehouses'] }}</span>
                </div>
                <div class="flex justify-between items-center p-2 bg-white border border-slate-200 text-xs">
                    <span class="text-slate-600 font-medium">{{ __('reports.total_items_quantity') }}</span>
                    <span class="font-mono font-bold text-slate-900">{{ number_format($warehouses['total_items']) }}</span>
                </div>
            </div>
        </div>

        <div class="border border-slate-200 p-4 bg-slate-50/50">
            <div class="border-b border-slate-300 pb-2 mb-3 flex justify-between items-center">
                <h2 class="font-bold text-xs uppercase tracking-wider text-slate-800">{{ __('reports.items_status') }}</h2>
                <span class="font-mono text-[10px] text-slate-400">REF: INV-02</span>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between items-center p-1.5 bg-white border border-slate-200 text-xs">
                    <span class="text-slate-600 font-medium">{{ __('reports.in_stock') }}</span>
                    <span class="font-mono font-bold text-emerald-600">{{ $status['in_stock'] }}</span>
                </div>
                <div class="flex justify-between items-center p-1.5 bg-white border border-slate-200 text-xs">
                    <span class="text-slate-600 font-medium">{{ __('reports.out_of_stock') }}</span>
                    <span class="font-mono font-bold text-rose-600">{{ $status['out_of_stock'] }}</span>
                </div>
                <div class="flex justify-between items-center p-1.5 bg-white border border-slate-200 text-xs">
                    <span class="text-slate-600 font-medium">{{ __('reports.discontinued') }}</span>
                    <span class="font-mono font-bold text-slate-500">{{ $status['discontinued'] }}</span>
                </div>
            </div>
        </div>

    </div>

    <div class="border border-slate-200 p-4 bg-slate-50/50">
        <div class="border-b border-slate-300 pb-2 mb-3 flex justify-between items-center">
            <h2 class="font-bold text-xs uppercase tracking-wider text-rose-700">{{ __('reports.inventory_alerts') }}</h2>
            <span class="font-mono text-[10px] text-slate-400">REF: INV-WARN</span>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div class="p-4 bg-amber-50/60 border border-amber-200 text-center">
                <span class="block text-xs font-mono font-bold text-amber-900 uppercase mb-1">{{ __('reports.expiring_soon') }}</span>
                <span class="font-mono text-3xl font-black text-amber-600">{{ $alerts['expiring_soon'] }}</span>
            </div>
            <div class="p-4 bg-rose-50/60 border border-rose-200 text-center">
                <span class="block text-xs font-mono font-bold text-rose-900 uppercase mb-1">{{ __('reports.expired_items') }}</span>
                <span class="font-mono text-3xl font-black text-rose-600">{{ $alerts['expired'] }}</span>
            </div>
        </div>
    </div>

</div>
@endsection
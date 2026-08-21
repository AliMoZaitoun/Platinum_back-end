@extends('reports.layout')

@section('report_title')
{{ __('reports.executive_summary') }}
@endsection

@section('content')
<div class="space-y-5">

    <!-- Hero KPI Banner -->
    <div class="bg-slate-900 text-white p-5 border-l-4 border-amber-500 flex justify-between items-center shadow-sm">
        <div>
            <span class="text-[10px] font-mono font-bold uppercase tracking-widest text-slate-400 block mb-1">
                {{ __('reports.total_revenue') }}
            </span>
            <div class="text-3xl font-black tracking-tight text-white flex items-baseline gap-1">
                {{ number_format($total_revenue, 2) }}
                <span class="text-lg text-amber-400 font-mono font-normal">$</span>
            </div>
        </div>
        <div class="border border-slate-700 font-mono text-[10px] px-2.5 py-1 text-slate-400 uppercase tracking-widest bg-slate-800/50">
            REF: SEC-FIN-01
        </div>
    </div>

    <!-- 3 Columns Stats Grid -->
    <div class="grid grid-cols-3 gap-4">

        <!-- Contracts -->
        <div class="border border-slate-200 bg-slate-50/50 p-4 relative">
            <div class="border-b border-slate-300 pb-2 mb-3 flex justify-between items-center">
                <h2 class="font-bold text-xs uppercase tracking-wider text-slate-800 flex items-center gap-1.5">
                    <span class="w-2 h-2 bg-slate-900 inline-block"></span>
                    {{ __('reports.contracts_stats') }}
                </h2>
                <span class="font-mono text-[10px] text-slate-400">01</span>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between items-center bg-white p-2 border border-slate-200 text-xs">
                    <span class="text-slate-600 font-medium">{{ __('reports.active') }}</span>
                    <span class="font-mono font-bold text-slate-900">{{ $contracts['active'] }}</span>
                </div>
                <div class="flex justify-between items-center bg-white p-2 border border-slate-200 text-xs">
                    <span class="text-slate-600 font-medium">{{ __('reports.pending_approval') }}</span>
                    <span class="font-mono font-bold text-amber-600">{{ $contracts['pending_approval'] }}</span>
                </div>
                <div class="flex justify-between items-center bg-white p-2 border border-slate-200 text-xs">
                    <span class="text-slate-600 font-medium">{{ __('reports.completed') }}</span>
                    <span class="font-mono font-bold text-emerald-600">{{ $contracts['completed'] }}</span>
                </div>
            </div>
        </div>

        <!-- Complaints -->
        <div class="border border-slate-200 bg-slate-50/50 p-4 relative">
            <div class="border-b border-slate-300 pb-2 mb-3 flex justify-between items-center">
                <h2 class="font-bold text-xs uppercase tracking-wider text-slate-800 flex items-center gap-1.5">
                    <span class="w-2 h-2 bg-slate-900 inline-block"></span>
                    {{ __('reports.complaints_stats') }}
                </h2>
                <span class="font-mono text-[10px] text-slate-400">02</span>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between items-center bg-white p-2 border border-slate-200 text-xs">
                    <span class="text-slate-600 font-medium">{{ __('reports.pending') }}</span>
                    <span class="font-mono font-bold text-amber-600">{{ $complaints['pending'] }}</span>
                </div>
                <div class="flex justify-between items-center bg-white p-2 border border-slate-200 text-xs">
                    <span class="text-slate-600 font-medium">{{ __('reports.resolved') }}</span>
                    <span class="font-mono font-bold text-emerald-600">{{ $complaints['resolved'] }}</span>
                </div>
            </div>
        </div>

        <!-- Real Estate Units -->
        <div class="border border-slate-200 bg-slate-50/50 p-4 relative">
            <div class="border-b border-slate-300 pb-2 mb-3 flex justify-between items-center">
                <h2 class="font-bold text-xs uppercase tracking-wider text-slate-800 flex items-center gap-1.5">
                    <span class="w-2 h-2 bg-slate-900 inline-block"></span>
                    {{ __('reports.units_stats') }}
                </h2>
                <span class="font-mono text-[10px] text-slate-400">03</span>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between items-center bg-white p-2 border border-slate-200 text-xs">
                    <span class="text-slate-600 font-medium">{{ __('reports.available') }}</span>
                    <span class="font-mono font-bold text-blue-600">{{ $units['available'] }}</span>
                </div>
                <div class="flex justify-between items-center bg-white p-2 border border-slate-200 text-xs">
                    <span class="text-slate-600 font-medium">{{ __('reports.sold') }}</span>
                    <span class="font-mono font-bold text-rose-600">{{ $units['sold'] }}</span>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
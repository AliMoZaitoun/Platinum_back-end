@extends('reports.layout')

@section('report_title')
{{ __('reports.executive_summary') }}
@endsection

@section('content')
<div class="space-y-8">

    <div class="border-2 border-slate-900 bg-slate-900 text-white p-6 relative overflow-hidden">
        <div class="flex justify-between items-center relative z-10">
            <div>
                <span class="text-xs font-mono font-bold uppercase tracking-widest text-slate-400 block mb-1">
                    {{ __('reports.total_revenue') }}
                </span>
                <div class="text-4xl font-black tracking-tight text-white">
                    {{ number_format($total_revenue, 2) }} <span class="text-xl text-amber-400 font-mono">$</span>
                </div>
            </div>
            <div class="hidden sm:block border border-slate-700 font-mono text-xs px-3 py-1.5 uppercase tracking-widest text-slate-300">
                [SEC-FIN-01]
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="border-2 border-slate-900 p-5 bg-white">
            <div class="border-b-2 border-slate-900 pb-2 mb-4 flex justify-between items-center">
                <h2 class="font-black text-sm uppercase tracking-wider text-slate-900">{{ __('reports.contracts_stats') }}</h2>
                <span class="font-mono text-xs text-slate-500">01</span>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between items-center p-2.5 bg-slate-50 border border-slate-300">
                    <span class="text-xs font-bold text-slate-700">{{ __('reports.active') }}</span>
                    <span class="font-mono font-black text-blue-600 text-lg">{{ $contracts['active'] }}</span>
                </div>
                <div class="flex justify-between items-center p-2.5 bg-slate-50 border border-slate-300">
                    <span class="text-xs font-bold text-slate-700">{{ __('reports.pending_approval') }}</span>
                    <span class="font-mono font-black text-amber-600 text-lg">{{ $contracts['pending_approval'] }}</span>
                </div>
                <div class="flex justify-between items-center p-2.5 bg-slate-50 border border-slate-300">
                    <span class="text-xs font-bold text-slate-700">{{ __('reports.completed') }}</span>
                    <span class="font-mono font-black text-emerald-600 text-lg">{{ $contracts['completed'] }}</span>
                </div>
            </div>
        </div>

        <div class="border-2 border-slate-900 p-5 bg-white">
            <div class="border-b-2 border-slate-900 pb-2 mb-4 flex justify-between items-center">
                <h2 class="font-black text-sm uppercase tracking-wider text-slate-900">{{ __('reports.complaints_stats') }}</h2>
                <span class="font-mono text-xs text-slate-500">02</span>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between items-center p-3 bg-slate-50 border border-slate-300">
                    <span class="text-xs font-bold text-slate-700">{{ __('reports.pending') }}</span>
                    <span class="font-mono font-black text-amber-600 text-xl">{{ $complaints['pending'] }}</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-slate-50 border border-slate-300">
                    <span class="text-xs font-bold text-slate-700">{{ __('reports.resolved') }}</span>
                    <span class="font-mono font-black text-emerald-600 text-xl">{{ $complaints['resolved'] }}</span>
                </div>
            </div>
        </div>

        <div class="border-2 border-slate-900 p-5 bg-white">
            <div class="border-b-2 border-slate-900 pb-2 mb-4 flex justify-between items-center">
                <h2 class="font-black text-sm uppercase tracking-wider text-slate-900">{{ __('reports.units_stats') }}</h2>
                <span class="font-mono text-xs text-slate-500">03</span>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between items-center p-3 bg-slate-50 border border-slate-300">
                    <span class="text-xs font-bold text-slate-700">{{ __('reports.available') }}</span>
                    <span class="font-mono font-black text-indigo-600 text-xl">{{ $units['available'] }}</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-slate-50 border border-slate-300">
                    <span class="text-xs font-bold text-slate-700">{{ __('reports.sold') }}</span>
                    <span class="font-mono font-black text-rose-600 text-xl">{{ $units['sold'] }}</span>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
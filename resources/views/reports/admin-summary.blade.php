@extends('reports.layout')

@section('report_title')
{{ __('reports.executive_summary') }}
@endsection

@section('content')
<div class="space-y-8">

    <div class="bg-gradient-to-r from-slate-900 to-slate-800 rounded-2xl p-6 text-white shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block mb-1">{{ __('reports.total_revenue') }}</span>
            <div class="text-4xl font-extrabold tracking-tight">
                {{ number_format($total_revenue, 2) }} <span class="text-xl text-emerald-400 font-normal">$</span>
            </div>
        </div>
        <div class="px-3 py-1 bg-emerald-500/20 text-emerald-300 rounded-full text-xs font-semibold border border-emerald-500/30">
            مؤشر مالي إيجابي
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex flex-col justify-between">
            <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4 border-b border-slate-100 pb-3">{{ __('reports.contracts_stats') }}</h2>
            <div class="space-y-3">
                <div class="flex justify-between items-center p-3 bg-blue-50/50 rounded-xl border border-blue-100">
                    <span class="text-xs font-semibold text-blue-900">{{ __('reports.active') }}</span>
                    <span class="text-lg font-extrabold text-blue-600">{{ $contracts['active'] }}</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-amber-50/50 rounded-xl border border-amber-100">
                    <span class="text-xs font-semibold text-amber-900">{{ __('reports.pending_approval') }}</span>
                    <span class="text-lg font-extrabold text-amber-600">{{ $contracts['pending_approval'] }}</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-emerald-50/50 rounded-xl border border-emerald-100">
                    <span class="text-xs font-semibold text-emerald-900">{{ __('reports.completed') }}</span>
                    <span class="text-lg font-extrabold text-emerald-600">{{ $contracts['completed'] }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex flex-col justify-between">
            <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4 border-b border-slate-100 pb-3">{{ __('reports.complaints_stats') }}</h2>
            <div class="space-y-3">
                <div class="flex justify-between items-center p-3.5 bg-amber-50/50 rounded-xl border border-amber-100">
                    <span class="text-xs font-semibold text-amber-900">{{ __('reports.pending') }}</span>
                    <span class="text-xl font-extrabold text-amber-600">{{ $complaints['pending'] }}</span>
                </div>
                <div class="flex justify-between items-center p-3.5 bg-emerald-50/50 rounded-xl border border-emerald-100">
                    <span class="text-xs font-semibold text-emerald-900">{{ __('reports.resolved') }}</span>
                    <span class="text-xl font-extrabold text-emerald-600">{{ $complaints['resolved'] }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex flex-col justify-between">
            <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4 border-b border-slate-100 pb-3">{{ __('reports.units_stats') }}</h2>
            <div class="space-y-3">
                <div class="flex justify-between items-center p-3.5 bg-indigo-50/50 rounded-xl border border-indigo-100">
                    <span class="text-xs font-semibold text-indigo-900">{{ __('reports.available') }}</span>
                    <span class="text-xl font-extrabold text-indigo-600">{{ $units['available'] }}</span>
                </div>
                <div class="flex justify-between items-center p-3.5 bg-rose-50/50 rounded-xl border border-rose-100">
                    <span class="text-xs font-semibold text-rose-900">{{ __('reports.sold') }}</span>
                    <span class="text-xl font-extrabold text-rose-600">{{ $units['sold'] }}</span>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
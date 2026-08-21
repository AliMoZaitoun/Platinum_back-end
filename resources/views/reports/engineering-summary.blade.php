@extends('reports.layout')

@section('report_title')
{{ __('reports.engineering_summary') }}
@endsection

@section('content')
<div class="space-y-5">

    <section class="border border-slate-200 p-4 bg-slate-50/50">
        <div class="border-b border-slate-300 pb-2 mb-3 flex justify-between items-center">
            <h2 class="font-bold text-xs uppercase tracking-wider text-slate-800">{{ __('reports.project_health') }}</h2>
            <span class="font-mono text-[10px] text-slate-400">REF: ENG-01</span>
        </div>

        <div class="grid grid-cols-4 gap-3">
            <div class="bg-white p-3 border border-slate-200 text-center">
                <span class="text-[10px] font-mono text-slate-500 uppercase block mb-1">{{ __('reports.on_track') }}</span>
                <span class="font-mono text-2xl font-bold text-emerald-600">{{ $health['on_track'] }}</span>
            </div>
            <div class="bg-white p-3 border border-slate-200 text-center">
                <span class="text-[10px] font-mono text-slate-500 uppercase block mb-1">{{ __('reports.delayed') }}</span>
                <span class="font-mono text-2xl font-bold text-amber-600">{{ $health['delayed'] }}</span>
            </div>
            <div class="bg-white p-3 border border-slate-200 text-center">
                <span class="text-[10px] font-mono text-slate-500 uppercase block mb-1">{{ __('reports.blocked') }}</span>
                <span class="font-mono text-2xl font-bold text-rose-600">{{ $health['blocked'] }}</span>
            </div>
            <div class="bg-white p-3 border border-slate-200 text-center">
                <span class="text-[10px] font-mono text-slate-500 uppercase block mb-1">{{ __('reports.site_issues') }}</span>
                <span class="font-mono text-2xl font-bold text-slate-900">{{ $health['total_issues'] }}</span>
            </div>
        </div>
    </section>

    <div class="grid grid-cols-2 gap-4">

        <section class="border border-slate-200 p-4 bg-slate-50/50">
            <div class="border-b border-slate-300 pb-2 mb-3 flex justify-between items-center">
                <h2 class="font-bold text-xs uppercase tracking-wider text-slate-800">{{ __('reports.engineers_allocation') }}</h2>
                <span class="font-mono text-[10px] text-slate-400">REF: ENG-02</span>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between items-center p-2 bg-white border border-slate-200 text-xs">
                    <span class="text-slate-600 font-medium">{{ __('reports.total_engineers') }}</span>
                    <span class="font-mono font-bold text-slate-900">{{ $engineers['total'] }}</span>
                </div>
                <div class="flex justify-between items-center p-2 bg-white border border-slate-200 text-xs">
                    <span class="text-slate-600 font-medium">{{ __('reports.allocated') }}</span>
                    <span class="font-mono font-bold text-blue-600">{{ $engineers['allocated'] }}</span>
                </div>
                <div class="flex justify-between items-center p-2 bg-white border border-slate-200 text-xs">
                    <span class="text-slate-600 font-medium">{{ __('reports.available_engineers') }}</span>
                    <span class="font-mono font-bold text-emerald-600">{{ $engineers['available'] }}</span>
                </div>
            </div>
        </section>

        <section class="border border-slate-200 p-4 bg-slate-50/50">
            <div class="border-b border-slate-300 pb-2 mb-3 flex justify-between items-center">
                <h2 class="font-bold text-xs uppercase tracking-wider text-slate-800">{{ __('reports.site_attendance') }}</h2>
                <span class="font-mono text-[10px] text-slate-400">REF: ENG-03</span>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between items-center p-2.5 bg-white border border-slate-200 text-xs">
                    <span class="text-slate-600 font-medium">{{ __('reports.checked_in_today') }}</span>
                    <span class="font-mono font-bold text-slate-900 text-sm">{{ $attendance['checked_in_today'] }}</span>
                </div>
                <div class="flex justify-between items-center p-2.5 bg-white border border-slate-200 text-xs">
                    <span class="text-slate-600 font-medium">{{ __('reports.avg_hours_week') }}</span>
                    <span class="font-mono font-bold text-amber-600 text-sm">{{ number_format($attendance['avg_hours_week'], 1) }}</span>
                </div>
            </div>
        </section>

    </div>

</div>
@endsection
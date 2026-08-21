@extends('reports.layout')

@section('report_title')
{{ __('reports.engineering_summary') }}
@endsection

@section('content')
<div class="space-y-8">

    <section class="border-2 border-slate-900 p-6 bg-white">
        <div class="border-b-2 border-slate-900 pb-3 mb-6 flex justify-between items-center">
            <h2 class="font-black text-base uppercase tracking-wider text-slate-900">{{ __('reports.project_health') }}</h2>
            <span class="font-mono text-xs text-slate-500">[ENG-01]</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="border-2 border-slate-900 p-4 bg-slate-50">
                <span class="text-[11px] font-mono font-bold uppercase text-slate-600 block mb-2">{{ __('reports.on_track') }}</span>
                <span class="font-mono text-3xl font-black text-emerald-600 block">{{ $health['on_track'] }}</span>
            </div>

            <div class="border-2 border-slate-900 p-4 bg-slate-50">
                <span class="text-[11px] font-mono font-bold uppercase text-slate-600 block mb-2">{{ __('reports.delayed') }}</span>
                <span class="font-mono text-3xl font-black text-amber-600 block">{{ $health['delayed'] }}</span>
            </div>

            <div class="border-2 border-slate-900 p-4 bg-slate-50">
                <span class="text-[11px] font-mono font-bold uppercase text-slate-600 block mb-2">{{ __('reports.blocked') }}</span>
                <span class="font-mono text-3xl font-black text-rose-600 block">{{ $health['blocked'] }}</span>
            </div>

            <div class="border-2 border-slate-900 p-4 bg-slate-50">
                <span class="text-[11px] font-mono font-bold uppercase text-slate-600 block mb-2">{{ __('reports.site_issues') }}</span>
                <span class="font-mono text-3xl font-black text-slate-900 block">{{ $health['total_issues'] }}</span>
            </div>
        </div>
    </section>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <section class="border-2 border-slate-900 p-6 bg-white">
            <div class="border-b-2 border-slate-900 pb-3 mb-6 flex justify-between items-center">
                <h2 class="font-black text-base uppercase tracking-wider text-slate-900">{{ __('reports.engineers_allocation') }}</h2>
                <span class="font-mono text-xs text-slate-500">[ENG-02]</span>
            </div>

            <div class="space-y-3">
                <div class="flex justify-between items-center p-3 border border-slate-300 bg-slate-50">
                    <span class="text-xs font-bold text-slate-700">{{ __('reports.total_engineers') }}</span>
                    <span class="font-mono font-black text-slate-900 text-base">{{ $engineers['total'] }}</span>
                </div>

                <div class="flex justify-between items-center p-3 border border-slate-300 bg-slate-50">
                    <span class="text-xs font-bold text-slate-700">{{ __('reports.allocated') }}</span>
                    <span class="font-mono font-black text-blue-600 text-base">{{ $engineers['allocated'] }}</span>
                </div>

                <div class="flex justify-between items-center p-3 border border-slate-300 bg-slate-50">
                    <span class="text-xs font-bold text-slate-700">{{ __('reports.available_engineers') }}</span>
                    <span class="font-mono font-black text-emerald-600 text-base">{{ $engineers['available'] }}</span>
                </div>
            </div>
        </section>

        <section class="border-2 border-slate-900 p-6 bg-white">
            <div class="border-b-2 border-slate-900 pb-3 mb-6 flex justify-between items-center">
                <h2 class="font-black text-base uppercase tracking-wider text-slate-900">{{ __('reports.site_attendance') }}</h2>
                <span class="font-mono text-xs text-slate-500">[ENG-03]</span>
            </div>

            <div class="space-y-3">
                <div class="flex justify-between items-center p-3.5 border border-slate-300 bg-slate-50">
                    <span class="text-xs font-bold text-slate-700">{{ __('reports.checked_in_today') }}</span>
                    <span class="font-mono font-black text-indigo-600 text-xl">{{ $attendance['checked_in_today'] }}</span>
                </div>

                <div class="flex justify-between items-center p-3.5 border border-slate-300 bg-slate-50">
                    <span class="text-xs font-bold text-slate-700">{{ __('reports.avg_hours_week') }}</span>
                    <span class="font-mono font-black text-amber-600 text-xl">{{ number_format($attendance['avg_hours_week'], 1) }}</span>
                </div>
            </div>
        </section>

    </div>

</div>
@endsection
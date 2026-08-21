@extends('layouts.report')

@section('report_title')
{{ __('reports.engineering_summary') }}
@endsection

@section('content')
<div class="space-y-8">

    <section class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-lg font-bold text-slate-900">{{ __('reports.project_health') }}</h2>
                <p class="text-xs text-slate-400 mt-0.5">مؤشرات الأداء العامة لحالة المشاريع</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="relative overflow-hidden bg-emerald-50/50 border border-emerald-100 p-5 rounded-xl">
                <div class="flex justify-between items-start">
                    <span class="text-xs font-semibold text-emerald-700 uppercase tracking-wider">{{ __('reports.on_track') }}</span>
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                </div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-3xl font-extrabold text-emerald-900">{{ $health['on_track'] }}</span>
                    <span class="text-xs text-emerald-600 font-medium">مشروع</span>
                </div>
            </div>

            <div class="relative overflow-hidden bg-amber-50/50 border border-amber-100 p-5 rounded-xl">
                <div class="flex justify-between items-start">
                    <span class="text-xs font-semibold text-amber-700 uppercase tracking-wider">{{ __('reports.delayed') }}</span>
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                </div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-3xl font-extrabold text-amber-900">{{ $health['delayed'] }}</span>
                    <span class="text-xs text-amber-600 font-medium">متأخر</span>
                </div>
            </div>

            <div class="relative overflow-hidden bg-rose-50/50 border border-rose-100 p-5 rounded-xl">
                <div class="flex justify-between items-start">
                    <span class="text-xs font-semibold text-rose-700 uppercase tracking-wider">{{ __('reports.blocked') }}</span>
                    <span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span>
                </div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-3xl font-extrabold text-rose-900">{{ $health['blocked'] }}</span>
                    <span class="text-xs text-rose-600 font-medium">متوقف</span>
                </div>
            </div>

            <div class="relative overflow-hidden bg-slate-100/60 border border-slate-200 p-5 rounded-xl">
                <div class="flex justify-between items-start">
                    <span class="text-xs font-semibold text-slate-600 uppercase tracking-wider">{{ __('reports.site_issues') }}</span>
                    <span class="w-2.5 h-2.5 rounded-full bg-slate-400"></span>
                </div>
                <div class="mt-4 flex items-baseline justify-between">
                    <span class="text-3xl font-extrabold text-slate-900">{{ $health['total_issues'] }}</span>
                    <span class="text-xs text-slate-500 font-medium">بلاغ</span>
                </div>
            </div>
        </div>
    </section>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <section class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex flex-col justify-between">
            <div>
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-bold text-slate-900">{{ __('reports.engineers_allocation') }}</h2>
                    <span class="text-xs text-slate-400">توزيع الكادر</span>
                </div>

                <div class="space-y-3">
                    <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-100 flex justify-between items-center">
                        <span class="text-sm font-medium text-slate-600">{{ __('reports.total_engineers') }}</span>
                        <span class="text-base font-bold text-slate-900">{{ $engineers['total'] }}</span>
                    </div>

                    <div class="p-3.5 bg-blue-50/50 rounded-xl border border-blue-100 flex justify-between items-center">
                        <span class="text-sm font-medium text-blue-900">{{ __('reports.allocated') }}</span>
                        <span class="text-base font-bold text-blue-600">{{ $engineers['allocated'] }}</span>
                    </div>

                    <div class="p-3.5 bg-emerald-50/50 rounded-xl border border-emerald-100 flex justify-between items-center">
                        <span class="text-sm font-medium text-emerald-900">{{ __('reports.available_engineers') }}</span>
                        <span class="text-base font-bold text-emerald-600">{{ $engineers['available'] }}</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex flex-col justify-between">
            <div>
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-bold text-slate-900">{{ __('reports.site_attendance') }}</h2>
                    <span class="text-xs text-slate-400">إحصائيات الموقع</span>
                </div>

                <div class="space-y-3">
                    <div class="p-4 bg-indigo-50/40 rounded-xl border border-indigo-100 flex justify-between items-center">
                        <span class="text-sm font-medium text-indigo-900">{{ __('reports.checked_in_today') }}</span>
                        <span class="text-2xl font-extrabold text-indigo-600">{{ $attendance['checked_in_today'] }}</span>
                    </div>

                    <div class="p-4 bg-amber-50/40 rounded-xl border border-amber-100 flex justify-between items-center">
                        <span class="text-sm font-medium text-amber-900">{{ __('reports.avg_hours_week') }}</span>
                        <span class="text-2xl font-extrabold text-amber-600">{{ number_format($attendance['avg_hours_week'], 1) }} <span class="text-xs font-normal">ساعة</span></span>
                    </div>
                </div>
            </div>
        </section>

    </div>

</div>
@endsection
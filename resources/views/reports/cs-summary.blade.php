@extends('reports.layout')

@section('report_title')
{{ __('reports.cs_summary') }}
@endsection

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
        <h2 class="text-lg font-bold text-slate-900 mb-6">{{ __('reports.chat_stats') }}</h2>
        <div class="space-y-3">
            <div class="flex justify-between items-center p-4 bg-blue-50/50 border border-blue-100 rounded-xl">
                <span class="text-sm font-medium text-slate-700">{{ __('reports.active_chats') }}</span>
                <span class="text-xl font-extrabold text-blue-600">{{ $chats['active_chats'] }}</span>
            </div>
            <div class="flex justify-between items-center p-4 bg-amber-50/50 border border-amber-100 rounded-xl">
                <span class="text-sm font-medium text-slate-700">{{ __('reports.open_chats') }}</span>
                <span class="text-xl font-extrabold text-amber-600">{{ $chats['open_chats'] }}</span>
            </div>
            <div class="flex justify-between items-center p-4 bg-emerald-50/50 border border-emerald-100 rounded-xl">
                <span class="text-sm font-medium text-slate-700">{{ __('reports.closed_chats') }}</span>
                <span class="text-xl font-extrabold text-emerald-600">{{ $chats['closed_chats'] }}</span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
        <h2 class="text-lg font-bold text-slate-900 mb-6">{{ __('reports.complaint_analytics') }}</h2>
        <div class="divide-y divide-slate-100">
            @foreach($analytics as $type => $count)
            <div class="flex justify-between items-center py-3.5 first:pt-0 last:pb-0">
                <span class="text-sm font-medium text-slate-600">{{ $type }}</span>
                <span class="px-3 py-1 bg-slate-100 text-slate-800 text-xs font-extrabold rounded-full">{{ $count }}</span>
            </div>
            @endforeach
        </div>
    </div>

</div>
@endsection
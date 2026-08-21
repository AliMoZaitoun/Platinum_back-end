@extends('reports.layout')

@section('report_title')
{{ __('reports.cs_summary') }}
@endsection

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <div class="border-2 border-slate-900 p-6 bg-white">
        <div class="border-b-2 border-slate-900 pb-3 mb-6 flex justify-between items-center">
            <h2 class="font-black text-base uppercase tracking-wider text-slate-900">{{ __('reports.chat_stats') }}</h2>
            <span class="font-mono text-xs text-slate-500">[CS-01]</span>
        </div>
        <div class="space-y-3">
            <div class="flex justify-between items-center p-3.5 border-2 border-slate-200 bg-slate-50">
                <span class="text-xs font-bold text-slate-800">{{ __('reports.active_chats') }}</span>
                <span class="font-mono font-black text-blue-600 text-xl">{{ $chats['active_chats'] }}</span>
            </div>
            <div class="flex justify-between items-center p-3.5 border-2 border-slate-200 bg-slate-50">
                <span class="text-xs font-bold text-slate-800">{{ __('reports.open_chats') }}</span>
                <span class="font-mono font-black text-amber-600 text-xl">{{ $chats['open_chats'] }}</span>
            </div>
            <div class="flex justify-between items-center p-3.5 border-2 border-slate-200 bg-slate-50">
                <span class="text-xs font-bold text-slate-800">{{ __('reports.closed_chats') }}</span>
                <span class="font-mono font-black text-emerald-600 text-xl">{{ $chats['closed_chats'] }}</span>
            </div>
        </div>
    </div>

    <div class="border-2 border-slate-900 p-6 bg-white">
        <div class="border-b-2 border-slate-900 pb-3 mb-6 flex justify-between items-center">
            <h2 class="font-black text-base uppercase tracking-wider text-slate-900">{{ __('reports.complaint_analytics') }}</h2>
            <span class="font-mono text-xs text-slate-500">[CS-02]</span>
        </div>
        <div class="divide-y-2 divide-slate-200">
            @foreach($analytics as $type => $count)
            <div class="flex justify-between items-center py-3">
                <span class="text-xs font-bold text-slate-700">{{ $type }}</span>
                <span class="font-mono font-black border border-slate-900 bg-slate-900 text-white px-2.5 py-0.5 text-xs">{{ $count }}</span>
            </div>
            @endforeach
        </div>
    </div>

</div>
@endsection
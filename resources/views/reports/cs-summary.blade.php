@extends('reports.layout')

@section('report_title')
{{ __('reports.cs_summary') }}
@endsection

@section('content')
<div class="grid grid-cols-2 gap-4">

    <!-- Chat Statistics -->
    <div class="border border-slate-200 p-4 bg-slate-50/50">
        <div class="border-b border-slate-300 pb-2 mb-3 flex justify-between items-center">
            <h2 class="font-bold text-xs uppercase tracking-wider text-slate-800">{{ __('reports.chat_stats') }}</h2>
            <span class="font-mono text-[10px] text-slate-400">REF: CS-01</span>
        </div>
        <div class="space-y-2">
            <div class="flex justify-between items-center p-2 bg-white border border-slate-200 text-xs">
                <span class="text-slate-600 font-medium">{{ __('reports.active_chats') }}</span>
                <span class="font-mono font-bold text-blue-600 text-sm">{{ $chats['active_chats'] }}</span>
            </div>
            <div class="flex justify-between items-center p-2 bg-white border border-slate-200 text-xs">
                <span class="text-slate-600 font-medium">{{ __('reports.open_chats') }}</span>
                <span class="font-mono font-bold text-amber-600 text-sm">{{ $chats['open_chats'] }}</span>
            </div>
            <div class="flex justify-between items-center p-2 bg-white border border-slate-200 text-xs">
                <span class="text-slate-600 font-medium">{{ __('reports.closed_chats') }}</span>
                <span class="font-mono font-bold text-emerald-600 text-sm">{{ $chats['closed_chats'] }}</span>
            </div>
        </div>
    </div>

    <!-- Complaint Analytics -->
    <div class="border border-slate-200 p-4 bg-slate-50/50">
        <div class="border-b border-slate-300 pb-2 mb-3 flex justify-between items-center">
            <h2 class="font-bold text-xs uppercase tracking-wider text-slate-800">{{ __('reports.complaint_analytics') }}</h2>
            <span class="font-mono text-[10px] text-slate-400">REF: CS-02</span>
        </div>
        <div class="space-y-2">
            @foreach($analytics as $type => $count)
            <div class="flex justify-between items-center p-2 bg-white border border-slate-200 text-xs">
                <span class="text-slate-600 font-medium">{{ $type }}</span>
                <span class="font-mono font-bold text-slate-900 border border-slate-300 bg-slate-100 px-2 py-0.5 text-[11px]">{{ $count }}</span>
            </div>
            @endforeach
        </div>
    </div>

</div>
@endsection
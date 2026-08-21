@extends('reports.layout')

@section('title', __('reports.cs_summary'))
@section('report_title', __('reports.cs_summary'))

@section('content')
<div class="grid grid-cols-2 gap-6">
    <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
        <h2 class="text-lg font-bold text-gray-700 mb-4">{{ __('reports.chat_stats') }}</h2>
        <ul class="text-gray-600 space-y-2">
            <li>{{ __('reports.active_chats') }}: <span class="font-bold text-blue-600">{{ $chats['active_chats'] }}</span></li>
            <li>{{ __('reports.open_chats') }}: <span class="font-bold text-yellow-600">{{ $chats['open_chats'] }}</span></li>
            <li>{{ __('reports.closed_chats') }}: <span class="font-bold text-green-600">{{ $chats['closed_chats'] }}</span></li>
        </ul>
    </div>

    <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
        <h2 class="text-lg font-bold text-gray-700 mb-4">{{ __('reports.complaint_analytics') }}</h2>
        @foreach($analytics as $type => $count)
        <div class="flex justify-between border-b py-1">
            <span>{{ $type }}</span>
            <span class="font-bold">{{ $count }}</span>
        </div>
        @endforeach
    </div>
</div>
@endsection
@extends('reports.layout')

@section('title', __('reports.executive_summary'))
@section('report_title', __('reports.executive_summary'))

@section('content')

<div class="grid grid-cols-2 gap-6">
    <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
        <h2 class="text-lg font-bold text-gray-700 mb-2">{{ __('reports.total_revenue') }}</h2>
        <p class="text-3xl text-green-600 font-bold">${{ number_format($total_revenue, 2) }}</p>
    </div>

    <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
        <h2 class="text-lg font-bold text-gray-700 mb-2">{{ __('reports.contracts_stats') }}</h2>
        <ul class="text-gray-600 space-y-1">
            <li>{{ __('reports.active') }}: <span class="font-bold">{{ $contracts['active'] }}</span></li>
            <li>{{ __('reports.pending_approval') }}: <span class="font-bold">{{ $contracts['pending_approval'] }}</span></li>
            <li>{{ __('reports.completed') }}: <span class="font-bold">{{ $contracts['completed'] }}</span></li>
        </ul>
    </div>

    <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
        <h2 class="text-lg font-bold text-gray-700 mb-2">{{ __('reports.complaints_stats') }}</h2>
        <ul class="text-gray-600 space-y-1">
            <li>{{ __('reports.pending') }}: <span class="font-bold text-yellow-600">{{ $complaints['pending'] }}</span></li>
            <li>{{ __('reports.resolved') }}: <span class="font-bold text-green-600">{{ $complaints['resolved'] }}</span></li>
        </ul>
    </div>

    <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
        <h2 class="text-lg font-bold text-gray-700 mb-2">{{ __('reports.units_stats') }}</h2>
        <ul class="text-gray-600 space-y-1">
            <li>{{ __('reports.available') }}: <span class="font-bold text-blue-600">{{ $units['available'] }}</span></li>
            <li>{{ __('reports.sold') }}: <span class="font-bold text-red-600">{{ $units['sold'] }}</span></li>
        </ul>
    </div>
</div>

@endsection
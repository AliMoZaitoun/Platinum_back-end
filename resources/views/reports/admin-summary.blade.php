@extends('reports.layout')

@section('title', __('reports.executive_summary'))
@section('report_title', __('reports.executive_summary'))

@section('content')
<div class="space-y-8">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="report-card p-8 border-t-4 border-green-500">
            <h2 class="text-sm uppercase tracking-widest text-gray-500 font-bold mb-3">{{ __('reports.total_revenue') }}</h2>
            <p class="text-5xl font-extrabold text-gray-900">{{ number_format($total_revenue, 2) }} <span class="text-2xl text-gray-400">$</span></p>
        </div>

        <div class="report-card p-8 border-t-4 border-blue-500">
            <h2 class="text-sm uppercase tracking-widest text-gray-500 font-bold mb-4">{{ __('reports.contracts_stats') }}</h2>
            <div class="flex justify-between items-center">
                <div class="text-center">
                    <span class="block text-3xl font-bold text-blue-600">{{ $contracts['active'] }}</span>
                    <span class="text-xs text-gray-500 uppercase">{{ __('reports.active') }}</span>
                </div>
                <div class="text-center">
                    <span class="block text-3xl font-bold text-yellow-600">{{ $contracts['pending_approval'] }}</span>
                    <span class="text-xs text-gray-500 uppercase">{{ __('reports.pending_approval') }}</span>
                </div>
                <div class="text-center">
                    <span class="block text-3xl font-bold text-green-700">{{ $contracts['completed'] }}</span>
                    <span class="text-xs text-gray-500 uppercase">{{ __('reports.completed') }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="report-card p-8 border-t-4 border-yellow-500">
            <h2 class="text-sm uppercase tracking-widest text-gray-500 font-bold mb-4">{{ __('reports.complaints_stats') }}</h2>
            <div class="flex gap-8">
                <div>
                    <span class="block text-3xl font-bold text-yellow-600">{{ $complaints['pending'] }}</span>
                    <span class="text-xs text-gray-500 uppercase">{{ __('reports.pending') }}</span>
                </div>
                <div>
                    <span class="block text-3xl font-bold text-green-600">{{ $complaints['resolved'] }}</span>
                    <span class="text-xs text-gray-500 uppercase">{{ __('reports.resolved') }}</span>
                </div>
            </div>
        </div>

        <div class="report-card p-8 border-t-4 border-indigo-500">
            <h2 class="text-sm uppercase tracking-widest text-gray-500 font-bold mb-4">{{ __('reports.units_stats') }}</h2>
            <div class="flex gap-8">
                <div>
                    <span class="block text-3xl font-bold text-blue-600">{{ $units['available'] }}</span>
                    <span class="text-xs text-gray-500 uppercase">{{ __('reports.available') }}</span>
                </div>
                <div>
                    <span class="block text-3xl font-bold text-red-600">{{ $units['sold'] }}</span>
                    <span class="text-xs text-gray-500 uppercase">{{ __('reports.sold') }}</span>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
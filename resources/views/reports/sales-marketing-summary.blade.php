<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <title>{{ __('reports.sales_marketing_summary') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 p-10">

    <div class="flex justify-between items-center border-b-2 border-gray-300 pb-4 mb-8">
        <div>
            <img src="{{ $logo_path }}" alt="Logo" class="h-16">
        </div>
        <div class="text-end">
            <h1 class="text-2xl font-bold text-gray-800">{{ __('reports.sales_marketing_summary') }}</h1>
            <p class="text-sm text-gray-500">{{ __('reports.issue_date') }}: {{ $generation_date }}</p>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg shadow border border-blue-100 col-span-2">
            <h2 class="text-lg font-bold text-blue-700 mb-4">{{ __('reports.sales_funnel') }}</h2>
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-blue-50 p-4 rounded text-center border border-blue-100">
                    <span class="block text-sm text-gray-500 mb-1">{{ __('reports.appointments_done') }}</span>
                    <span class="text-3xl font-bold text-blue-600">{{ $funnel['appointments_done'] }}</span>
                </div>
                <div class="bg-indigo-50 p-4 rounded text-center border border-indigo-100">
                    <span class="block text-sm text-gray-500 mb-1">{{ __('reports.orders_received') }}</span>
                    <span class="text-3xl font-bold text-indigo-600">{{ $funnel['orders_received'] }}</span>
                </div>
                <div class="bg-green-50 p-4 rounded text-center border border-green-100">
                    <span class="block text-sm text-gray-500 mb-1">{{ __('reports.orders_accepted') }}</span>
                    <span class="text-3xl font-bold text-green-600">{{ $funnel['orders_accepted'] }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
            <h2 class="text-lg font-bold text-gray-700 mb-2">{{ __('reports.ads_stats') }}</h2>
            <ul class="text-gray-600 space-y-2">
                <li class="flex justify-between">
                    <span>{{ __('reports.active_ads') }}:</span>
                    <span class="font-bold text-green-600">{{ $ads['active'] }}</span>
                </li>
                <li class="flex justify-between border-t pt-2 mt-2">
                    <span>{{ __('reports.total_ads') }}:</span>
                    <span class="font-bold">{{ $ads['total'] }}</span>
                </li>
            </ul>
        </div>

        <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
            <h2 class="text-lg font-bold text-gray-700 mb-2">{{ __('reports.offers_stats') }}</h2>
            <ul class="text-gray-600 space-y-2">
                <li class="flex justify-between">
                    <span>{{ __('reports.active_offers') }}:</span>
                    <span class="font-bold text-blue-600">{{ $offers['active'] }}</span>
                </li>
                <li class="flex justify-between border-t pt-2 mt-2">
                    <span>{{ __('reports.avg_discount') }}:</span>
                    <span class="font-bold text-orange-500">%{{ number_format($offers['avg_discount'], 1) }}</span>
                </li>
            </ul>
        </div>
    </div>

</body>

</html>
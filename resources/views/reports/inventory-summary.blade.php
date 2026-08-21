<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <title>{{ __('reports.inventory_summary') }}</title>
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
            <h1 class="text-2xl font-bold text-gray-800">{{ __('reports.inventory_summary') }}</h1>
            <p class="text-sm text-gray-500">{{ __('reports.issue_date') }}: {{ $generation_date }}</p>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-6">

        <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
            <h2 class="text-lg font-bold text-gray-700 mb-2">{{ __('reports.warehouses_overview') }}</h2>
            <ul class="text-gray-600 space-y-2">
                <li class="flex justify-between">
                    <span>{{ __('reports.total_warehouses') }}:</span>
                    <span class="font-bold text-blue-600">{{ $warehouses['total_warehouses'] }}</span>
                </li>
                <li class="flex justify-between border-t pt-2 mt-2">
                    <span>{{ __('reports.total_items_quantity') }}:</span>
                    <span class="font-bold text-gray-800">{{ number_format($warehouses['total_items']) }}</span>
                </li>
            </ul>
        </div>

        <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
            <h2 class="text-lg font-bold text-gray-700 mb-2">{{ __('reports.items_status') }}</h2>
            <ul class="text-gray-600 space-y-2">
                <li class="flex justify-between">
                    <span>{{ __('reports.in_stock') }}:</span>
                    <span class="font-bold text-green-600">{{ $status['in_stock'] }}</span>
                </li>
                <li class="flex justify-between border-t pt-2 mt-2">
                    <span>{{ __('reports.out_of_stock') }}:</span>
                    <span class="font-bold text-red-600">{{ $status['out_of_stock'] }}</span>
                </li>
                <li class="flex justify-between border-t pt-2 mt-2">
                    <span>{{ __('reports.discontinued') }}:</span>
                    <span class="font-bold text-gray-500">{{ $status['discontinued'] }}</span>
                </li>
            </ul>
        </div>

        <div class="bg-white p-6 rounded-lg shadow border border-red-100 col-span-2">
            <h2 class="text-lg font-bold text-red-700 mb-4">{{ __('reports.inventory_alerts') }}</h2>
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-orange-50 p-4 rounded text-center border border-orange-100">
                    <span class="block text-sm text-gray-600 mb-1">{{ __('reports.expiring_soon') }} (30 {{ __('reports.days') }})</span>
                    <span class="text-3xl font-bold text-orange-600">{{ $alerts['expiring_soon'] }}</span>
                </div>
                <div class="bg-red-50 p-4 rounded text-center border border-red-100">
                    <span class="block text-sm text-gray-600 mb-1">{{ __('reports.expired_items') }}</span>
                    <span class="text-3xl font-bold text-red-600">{{ $alerts['expired'] }}</span>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
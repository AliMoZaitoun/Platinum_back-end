<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <title>{{ __('reports.engineering_summary') }}</title>
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
            <h1 class="text-2xl font-bold text-gray-800">{{ __('reports.engineering_summary') }}</h1>
            <p class="text-sm text-gray-500">{{ __('reports.issue_date') }}: {{ $generation_date }}</p>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-6">

        <div class="bg-white p-6 rounded-lg shadow border border-gray-100 col-span-2">
            <h2 class="text-lg font-bold text-gray-700 mb-4">{{ __('reports.project_health') }}</h2>
            <div class="grid grid-cols-4 gap-4">
                <div class="bg-green-50 p-4 rounded text-center border border-green-100">
                    <span class="block text-sm text-gray-500 mb-1">{{ __('reports.on_track') }}</span>
                    <span class="text-3xl font-bold text-green-600">{{ $health['on_track'] }}</span>
                </div>
                <div class="bg-yellow-50 p-4 rounded text-center border border-yellow-100">
                    <span class="block text-sm text-gray-500 mb-1">{{ __('reports.delayed') }}</span>
                    <span class="text-3xl font-bold text-yellow-600">{{ $health['delayed'] }}</span>
                </div>
                <div class="bg-red-50 p-4 rounded text-center border border-red-100">
                    <span class="block text-sm text-gray-500 mb-1">{{ __('reports.blocked') }}</span>
                    <span class="text-3xl font-bold text-red-600">{{ $health['blocked'] }}</span>
                </div>
                <div class="bg-gray-100 p-4 rounded text-center border border-gray-200">
                    <span class="block text-sm text-gray-500 mb-1">{{ __('reports.site_issues') }}</span>
                    <span class="text-3xl font-bold text-gray-700">{{ $health['total_issues'] }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
            <h2 class="text-lg font-bold text-gray-700 mb-2">{{ __('reports.engineers_allocation') }}</h2>
            <ul class="text-gray-600 space-y-2">
                <li class="flex justify-between">
                    <span>{{ __('reports.total_engineers') }}:</span>
                    <span class="font-bold">{{ $engineers['total'] }}</span>
                </li>
                <li class="flex justify-between border-t pt-2 mt-2">
                    <span>{{ __('reports.allocated') }}:</span>
                    <span class="font-bold text-blue-600">{{ $engineers['allocated'] }}</span>
                </li>
                <li class="flex justify-between border-t pt-2 mt-2">
                    <span>{{ __('reports.available_engineers') }}:</span>
                    <span class="font-bold text-green-600">{{ $engineers['available'] }}</span>
                </li>
            </ul>
        </div>

        <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
            <h2 class="text-lg font-bold text-gray-700 mb-2">{{ __('reports.site_attendance') }}</h2>
            <ul class="text-gray-600 space-y-2">
                <li class="flex justify-between">
                    <span>{{ __('reports.checked_in_today') }}:</span>
                    <span class="font-bold text-indigo-600">{{ $attendance['checked_in_today'] }}</span>
                </li>
                <li class="flex justify-between border-t pt-2 mt-2">
                    <span>{{ __('reports.avg_hours_week') }}:</span>
                    <span class="font-bold text-orange-500">{{ number_format($attendance['avg_hours_week'], 1) }}</span>
                </li>
            </ul>
        </div>
    </div>

</body>

</html>
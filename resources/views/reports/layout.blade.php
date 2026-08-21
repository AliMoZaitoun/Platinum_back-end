<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'التقرير')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
        }

        @page {
            margin: 0;
        }
    </style>
</head>

<body class="bg-gray-50 p-10">

    <div class="flex justify-between items-center border-b-2 border-gray-300 pb-4 mb-8">
        <div>
            <img src="{{ $logo_path }}" alt="Logo" class="h-16">
        </div>
        <div class="text-end">
            <h1 class="text-2xl font-bold text-gray-800">@yield('report_title')</h1>
            <p class="text-sm text-gray-500">{{ __('reports.issue_date') }}: {{ $generation_date }}</p>
        </div>
    </div>

    <main>
        @yield('content')
    </main>

    <div class="mt-12 pt-4 border-t border-gray-200 text-center text-xs text-gray-400">
        تم توليد هذا التقرير آلياً عبر نظام إدارة الموارد - {{ config('app.name', 'ERP System') }}
    </div>

</body>

</html>
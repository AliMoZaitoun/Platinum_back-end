<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;700&display=swap');

        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #f8fafc;
        }

        .report-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        }
    </style>
</head>

<body class="p-12 text-gray-800">

    <div class="flex justify-between items-start mb-12">
        <div class="w-1/3">
            <img src="{{ $logo_path }}" class="h-20 w-auto object-contain">
        </div>
        <div class="text-end w-2/3 border-r-4 border-blue-600 pr-6">
            <h1 class="text-4xl font-bold text-gray-900 tracking-tight">@yield('report_title')</h1>
            <p class="text-blue-600 font-medium mt-2">{{ __('reports.issue_date') }}: {{ $generation_date }}</p>
        </div>
    </div>

    <main>
        @yield('content')
    </main>

    <footer class="fixed bottom-10 left-10 right-10 border-t border-gray-200 pt-6 flex justify-between text-gray-400 text-sm">
        <span>{{ config('app.name') }} &copy; {{ date('Y') }}</span>
        <span>صفحة 1 من 1</span>
    </footer>
</body>

</html>
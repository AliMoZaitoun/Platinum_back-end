<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap');

        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #f8fafc;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col justify-between p-8 md:p-12">

    <div>
        <header class="flex justify-between items-center border-b border-slate-200 pb-6 mb-8">
            <div class="flex items-center">
                <img src="{{ $logo_path }}" class="h-14 w-auto object-contain">
            </div>
            <div class="text-end">
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">@yield('report_title')</h1>
                <p class="text-xs font-semibold text-slate-400 mt-1">{{ __('reports.issue_date') }}: <span class="text-slate-600">{{ $generation_date }}</span></p>
            </div>
        </header>

        <main>
            @yield('content')
        </main>
    </div>

    <footer class="mt-12 pt-6 border-t border-slate-200 flex justify-between items-center text-xs text-slate-400 font-medium">
        <span>تقرير تنفيذي محمي</span>
        <span>صفحة 1 من 1</span>
    </footer>

</body>

</html>
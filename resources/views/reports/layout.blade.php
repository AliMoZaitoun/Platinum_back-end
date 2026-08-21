<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800;900&display=swap');

        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #ffffff;
            color: #0f172a;
        }

        @media print {
            @page {
                size: A4 portrait;
                margin: 12mm;
            }

            body {
                padding: 0;
                background: white;
            }
        }
    </style>
</head>

<body class="bg-white text-slate-900 antialiased p-6 max-w-[210mm] mx-auto border border-slate-200 shadow-sm my-4">

    <!-- Header Section -->
    <header class="flex justify-between items-center border-b-2 border-slate-900 pb-4 mb-5">
        <div class="flex items-center gap-3">
            <img src="{{ $logo_path }}" class="h-12 w-auto object-contain">
        </div>

        <div class="text-end">
            <div class="inline-block bg-amber-500 text-slate-950 text-[9px] font-bold tracking-widest px-2 py-0.5 uppercase mb-1">
                {{ __('reports.official_document') }}
            </div>
            <h1 class="text-xl font-black text-slate-900 uppercase tracking-tight">@yield('report_title')</h1>
            <p class="text-[11px] font-mono font-medium text-slate-500">
                {{ __('reports.issue_date') }}: <span class="text-slate-800 font-bold">{{ $generation_date }}</span>
            </p>
        </div>
    </header>

    <!-- Content Area -->
    <main class="min-h-[680px]">
        @yield('content')
    </main>

    <!-- Footer Section -->
    <footer class="mt-6 pt-3 border-t border-slate-300 flex justify-between items-center text-[10px] font-mono text-slate-500 uppercase tracking-wider">
        <div class="flex items-center gap-2">
            <span class="w-1.5 h-1.5 bg-amber-500 inline-block"></span>
            <span>{{ config('app.name') }} | {{ __('reports.confidential') }}</span>
        </div>
        <span>{{ __('reports.page') }} 1 / 1</span>
    </footer>

</body>

</html>
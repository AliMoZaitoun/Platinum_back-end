<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800;900&display=swap');

        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #f8fafc;
        }

        .blueprint-grid {
            background-image: linear-gradient(to right, #e2e8f0 1px, transparent 1px),
                linear-gradient(to bottom, #e2e8f0 1px, transparent 1px);
            background-size: 20px 20px;
        }
    </style>
</head>

<body class="bg-slate-100 text-slate-900 antialiased min-h-screen flex flex-col justify-between p-6 md:p-10 blueprint-grid">

    <div class="bg-white border-2 border-slate-900 shadow-[6px_6px_0px_0px_rgba(15,23,42,1)] p-8">

        <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b-2 border-slate-900 pb-6 mb-8 gap-4">
            <div class="flex items-center gap-4">
                <img src="{{ $logo_path }}" class="h-16 w-auto object-contain">
            </div>

            <div class="text-end border-s-0 sm:border-s-2 border-slate-900 sm:ps-6">
                <div class="inline-block bg-slate-900 text-white text-[10px] font-mono uppercase tracking-widest px-2 py-0.5 mb-1">
                    {{ __('reports.official_document') }}
                </div>
                <h1 class="text-2xl font-black text-slate-900 uppercase tracking-tight">@yield('report_title')</h1>
                <p class="text-xs font-mono font-bold text-slate-600 mt-1">
                    {{ __('reports.issue_date') }}: <span class="text-slate-900">{{ $generation_date }}</span>
                </p>
            </div>
        </header>

        <main>
            @yield('content')
        </main>

        <footer class="mt-12 pt-4 border-t-2 border-slate-900 flex justify-between items-center font-mono text-xs text-slate-700 font-bold uppercase tracking-wider">
            <span>{{ config('app.name') }} | {{ __('reports.confidential') }}</span>
            <span>{{ __('reports.page') }} 1 / 1</span>
        </footer>

    </div>

</body>

</html>
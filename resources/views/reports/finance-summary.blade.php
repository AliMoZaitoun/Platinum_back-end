<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <title>{{ __('reports.finance_summary') }}</title>
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
            <h1 class="text-2xl font-bold text-gray-800">{{ __('reports.finance_summary') }}</h1>
            <p class="text-sm text-gray-500">{{ __('reports.issue_date') }}: {{ $generation_date }}</p>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg shadow border border-red-100">
            <h2 class="text-lg font-bold text-red-700 mb-2">{{ __('reports.overdue_payments') }}</h2>
            <p class="text-3xl text-red-600 font-bold">${{ number_format($overdue['total_amount'], 2) }}</p>
            <p class="text-sm text-gray-500 mt-2">{{ __('reports.overdue_count') }}: <span class="font-bold">{{ $overdue['count'] }}</span></p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
            <h2 class="text-lg font-bold text-gray-700 mb-2">{{ __('reports.monthly_cash_flow') }}</h2>
            <ul class="text-gray-600 space-y-2">
                <li class="flex justify-between">
                    <span>{{ __('reports.receipts') }}:</span>
                    <span class="font-bold text-green-600">+${{ number_format($cash_flow['receipts'], 2) }}</span>
                </li>
                <li class="flex justify-between">
                    <span>{{ __('reports.payments_out') }}:</span>
                    <span class="font-bold text-red-600">-${{ number_format($cash_flow['payments'], 2) }}</span>
                </li>
            </ul>
        </div>

        <div class="bg-white p-6 rounded-lg shadow border border-gray-100 col-span-2">
            <h2 class="text-lg font-bold text-gray-700 mb-2">{{ __('reports.payment_methods') }}</h2>
            <div class="grid grid-cols-4 gap-4 mt-4">
                <div class="bg-gray-50 p-4 rounded text-center">
                    <span class="block text-sm text-gray-500">{{ __('reports.cash') }}</span>
                    <span class="font-bold">${{ number_format($payment_methods['cash'], 2) }}</span>
                </div>
                <div class="bg-gray-50 p-4 rounded text-center">
                    <span class="block text-sm text-gray-500">{{ __('reports.bank_transfer') }}</span>
                    <span class="font-bold">${{ number_format($payment_methods['bank_transfer'], 2) }}</span>
                </div>
                <div class="bg-gray-50 p-4 rounded text-center">
                    <span class="block text-sm text-gray-500">{{ __('reports.check') }}</span>
                    <span class="font-bold">${{ number_format($payment_methods['check'], 2) }}</span>
                </div>
                <div class="bg-gray-50 p-4 rounded text-center">
                    <span class="block text-sm text-gray-500">{{ __('reports.card') }}</span>
                    <span class="font-bold">${{ number_format($payment_methods['card'], 2) }}</span>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
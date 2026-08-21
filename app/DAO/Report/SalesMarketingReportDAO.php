<?php

namespace App\DAO\Report;

use App\Models\Sales\Order;
use App\Models\Marketing\Advertisement;
use App\Models\Marketing\Offer;
use App\Models\Sales\Appointment;

class SalesMarketingReportDAO
{
    public function getSalesFunnelStats(): array
    {
        return [
            'appointments_done' => Appointment::where('status', 'done')->count(),
            'orders_received'   => Order::count(),
            'orders_accepted'   => Order::where('status', 'accepted')->count(),
        ];
    }

    public function getAdvertisementsStats(): array
    {
        return [
            'active' => Advertisement::where('status', 1)
                ->where('ends_at', '>=', now())
                ->count(),
            'total'  => Advertisement::count(),
        ];
    }

    public function getOffersStats(): array
    {
        return [
            'active'       => Offer::where('status', 1)
                ->where(function ($q) {
                    $q->whereNull('end_date')
                        ->orWhere('end_date', '>=', now());
                })->count(),
            'avg_discount' => Offer::where('status', 1)->avg('discount_percentage') ?? 0,
        ];
    }
}

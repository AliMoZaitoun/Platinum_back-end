<?php

namespace App\DAO\Report;

use App\Models\Core\Item;
use App\Models\Core\Warehouse;
use Carbon\Carbon;

class InventoryReportDAO
{
    public function getWarehousesStats(): array
    {
        return [
            'total_warehouses' => Warehouse::count(),
            'total_items'      => Item::sum('quantity'),
        ];
    }

    public function getItemsStatusStats(): array
    {
        return [
            'in_stock'     => Item::where('status', 'in_stock')->count(),
            'out_of_stock' => Item::where('status', 'out_of_stock')->orWhere('quantity', '<=', 0)->count(),
            'discontinued' => Item::where('status', 'discontinued')->count(),
        ];
    }

    public function getAlertsStats(): array
    {
        return [
            'expiring_soon' => Item::whereNotNull('expiry_date')
                ->whereBetween('expiry_date', [Carbon::today(), Carbon::today()->addDays(30)])
                ->count(),
            'expired'       => Item::whereNotNull('expiry_date')
                ->where('expiry_date', '<', Carbon::today())
                ->count(),
        ];
    }
}

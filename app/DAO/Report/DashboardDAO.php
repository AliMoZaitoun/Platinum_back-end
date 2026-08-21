<?php

namespace App\DAO\Report;

use App\Models\Finance\Payment;
use App\Models\Legal\Contract;
use App\Models\RealEstate\Unit;
use App\Models\Sales\Complaint;

class DashboardDAO
{
    public function getTotalRevenue(): float
    {
        return Payment::where('status', 'paid')->sum('amount');
    }

    public function getContractsStats(): array
    {
        return [
            'active' => Contract::where('status', 'active')->count(),
            'pending_approval' => Contract::where('status', 'pending_approval')->count(),
            'completed' => Contract::where('status', 'completed')->count(),
        ];
    }

    public function getComplaintsStats(): array
    {
        return [
            'pending' => Complaint::where('status', 'pending')->count(),
            'resolved' => Complaint::where('status', 'resolved')->count(),
        ];
    }

    public function getUnitsStats(): array
    {
        return [
            'available' => Unit::where('status', 'available')->count(),
            'sold' => Unit::where('status', 'sold')->count(),
        ];
    }
}

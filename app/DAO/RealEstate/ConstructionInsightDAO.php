<?php

namespace App\DAO\RealEstate;

use App\Models\RealEstate\ConstructionInsight;

class ConstructionInsightDAO
{
    public function updateOrCreate(array $data)
    {
        return ConstructionInsight::updateOrCreate(
            [
                'construction_report_id' => $data['construction_report_id'],
                'type'                   => $data['type'],
            ],
            $data
        );
    }

    public function index(array $filters = [])
    {
        return ConstructionInsight::with([
            'report.building',
            'report.engineer'
        ])
            ->when(isset($filters['building_id']), fn($q) => $q->where('building_id', $filters['building_id']))
            ->when(isset($filters['severity']), fn($q) => $q->where('severity', $filters['severity']))
            ->when(isset($filters['is_read']), fn($q) => $q->where('is_read', filter_var($filters['is_read'], FILTER_VALIDATE_BOOLEAN)))
            ->latest()
            ->paginate($filters['per_page'] ?? 15);
    }

    public function markAsRead(int $id): bool
    {
        return ConstructionInsight::where('id', $id)->update(['is_read' => true]);
    }
}

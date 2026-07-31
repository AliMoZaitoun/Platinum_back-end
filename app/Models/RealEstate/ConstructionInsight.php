<?php

namespace App\Models\RealEstate;

use App\Enums\Reports\InsightSeverity;
use App\Enums\Reports\InsightType;
use App\Models\Engineer\ConstructionReport;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'building_id',
    'construction_report_id',
    'phase',
    'type',
    'severity',
    'title',
    'diagnosis',
    'recommendation',
    'metrics',
    'is_read',
    'resolved_at'
])]
class ConstructionInsight extends Model
{
    protected $casts = [
        'type'        => InsightType::class,
        'severity'    => InsightSeverity::class,
        'metrics'     => 'array',
        'is_read'     => 'boolean',
        'resolved_at' => 'datetime',
    ];

    public function report()
    {
        return $this->belongsTo(ConstructionReport::class, 'construction_report_id');
    }
}

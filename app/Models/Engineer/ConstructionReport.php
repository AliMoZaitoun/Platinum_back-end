<?php

namespace App\Models\Engineer;

use App\Models\Media;
use App\Models\RealEstate\Building;
use App\Models\RealEstate\Project;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'uuid',
    'project_id',
    'building_id',
    'engineer_id',
    'phase',
    'completion_percentage',
    'daily_progress',
    'status',
    'report_date',
    'manpower_count',
    'issues_count',
    'recorded_at',
    'description'
])]

class ConstructionReport extends Model
{
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function engineer()
    {
        return $this->belongsTo(Engineer::class);
    }

    public function attachments()
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}

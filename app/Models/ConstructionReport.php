<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'uuid',
    'project_id',
    'engineer_id',
    'phase',
    'completion_percentage',
    'daily_progress',
    'status',
    'manpower_count',
    'issues_count',
    'recorded_at'
])]
class ConstructionReport extends Model
{
    public function project()
    {
        return $this->belongsTo(Project::class);
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

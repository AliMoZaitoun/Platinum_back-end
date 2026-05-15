<?php

namespace App\Models\Engineer;

use App\Models\RealEstate\Project;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'uuid',
    'engineer_id',
    'project_id',
    'check_in',
    'check_out',
    'check_in_lat',
    'check_in_lng',
    'check_out_lat',
    'check_out_lng',
    'device_id',
    'recorded_at'
])]

class Attendance extends Model
{
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function engineer()
    {
        return $this->belongsTo(Engineer::class);
    }
}

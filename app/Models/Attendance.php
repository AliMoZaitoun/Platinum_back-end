<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'uuid',
    'engineer_id',
    'project_id',
    'check_in',
    'check_out',
    'check_in_lng',
    'check_out_lag',
    'check_out_lng',
    'status',
    'device_id',
    'user_created_at'
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

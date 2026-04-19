<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['project_id', 'building_number', 'floors_count', 'status'])]
class Building extends Model
{
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function units()
    {
        return $this->hasMany(Unit::class);
    }
}

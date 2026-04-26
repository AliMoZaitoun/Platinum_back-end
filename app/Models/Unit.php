<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['building_id', 'unit_number', 'type', 'floor', 'area', 'rooms_count', 'price', 'status'])]
class Unit extends Model
{
    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getLocationAttribute($value)
    {
        return $value ?? $this->building->location;
    }
}

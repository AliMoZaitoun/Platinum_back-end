<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['building_id', 'unit_number', 'floor', 'area', 'price', 'status'])]
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
}

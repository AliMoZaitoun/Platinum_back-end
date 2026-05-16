<?php

namespace App\Models\Core;

use App\Models\RealEstate\Location;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'location_id', 'address'])]
class Warehouse extends Model
{
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}

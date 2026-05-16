<?php

namespace App\Models\RealEstate;

use App\Models\Core\Warehouse;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'type', 'parent_id'])]
class Location extends Model
{
    protected $casts = [
        'name' => 'array'
    ];

    public function parent()
    {
        return $this->belongsTo(Location::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Location::class, 'parent_id');
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function buildings()
    {
        return $this->hasMany(Building::class);
    }

    public function warehouses()
    {
        return $this->hasMany(Warehouse::class);
    }
}

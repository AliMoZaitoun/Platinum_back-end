<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'description', 'latitude', 'longitude', 'status'])]
class Project extends Model
{
    public function buildings()
    {
        return $this->hasMany(Building::class);
    }
}

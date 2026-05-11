<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'location'])]
class Warehouse extends Model
{
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}

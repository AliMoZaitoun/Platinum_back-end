<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'description', 'price'])]
class Offering extends Model
{
    public function orders()
    {
        return $this->hasMany(Offering::class);
    }
}

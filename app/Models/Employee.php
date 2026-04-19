<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['user_id', 'position'])]

class Employee extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function av_slots()
    {
        return $this->hasMany(Availability_slot::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['user_id', 'specialization', 'experience_years'])]

class Engineer extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

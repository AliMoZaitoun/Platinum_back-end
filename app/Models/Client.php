<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['user_id', 'birth_date', 'job_title', 'social_status', 'national_id'])]

class Client extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

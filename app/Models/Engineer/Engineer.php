<?php

namespace App\Models\Engineer;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['user_id', 'specialization', 'experience_years'])]

class Engineer extends BaseModel
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function projects()
    {
        return $this->hasMany(ProjectEngineerAllocation::class);
    }
}

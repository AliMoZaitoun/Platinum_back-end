<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'description', 'price'])]
class Solution extends Model
{
    public function orders()
    {
        return $this->hasMany(Solution::class);
    }
}

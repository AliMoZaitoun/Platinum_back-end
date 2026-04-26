<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'description', 'status', 'duration', 'created_by'])]
class Advertisement extends Model
{
    public function created_by()
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }
}

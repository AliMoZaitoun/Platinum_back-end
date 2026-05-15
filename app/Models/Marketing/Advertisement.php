<?php

namespace App\Models\Marketing;

use App\Models\Core\Employee;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'description', 'status', 'duration', 'created_by', 'end_date'])]
class Advertisement extends Model
{
    public function created_by()
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }
}

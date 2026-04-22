<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['employee_id', 'start_time', 'status', 'batch_id'])]
class AvailabilitySlot extends Model
{
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}

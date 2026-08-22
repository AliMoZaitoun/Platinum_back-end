<?php

namespace App\Models\Sales;

use App\Models\Core\Employee;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['employee_id', 'start_time', 'status', 'batch_id'])]
class AvailabilitySlot extends BaseModel
{
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'av_slot_id');
    }
}

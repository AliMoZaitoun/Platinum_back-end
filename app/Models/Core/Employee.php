<?php

namespace App\Models\Core;

use App\Models\Marketing\Advertisement;
use App\Models\Sales\AvailabilitySlot;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['user_id'])]

class Employee extends Model
{
    use SoftDeletes;
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function av_slots()
    {
        return $this->hasMany(AvailabilitySlot::class);
    }

    public function departments()
    {
        return $this->hasMany(EmployeeDepartment::class);
    }

    public function advertisments()
    {
        return $this->hasMany(Advertisement::class);
    }
}

<?php

namespace App\Models\Core;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['employee_id', 'department_id', 'from_date', 'position', 'to_date'])]
class EmployeeDepartment extends BaseModel
{
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}

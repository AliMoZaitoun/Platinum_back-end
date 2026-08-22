<?php

namespace App\Models;

use App\Models\Core\Employee;
use App\Models\Sales\Order;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['text', 'noteable_id', 'noteable_type', 'created_by'])]
class Note extends BaseModel
{
    public function noteable()
    {
        return $this->morphTo();
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

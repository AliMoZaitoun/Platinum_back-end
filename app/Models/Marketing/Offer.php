<?php

namespace App\Models\Marketing;

use App\Models\BaseModel;
use App\Models\Core\Employee;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['discount_percentage', 'offerable_id', 'offerable_type', 'old_price', 'new_price', 'start_date', 'end_date', 'status', 'created_by'])]
class Offer extends BaseModel
{
    use SoftDeletes;

    public function advertisements()
    {
        return $this->hasMany(Advertisement::class);
    }

    public function offerable()
    {
        return $this->morphTo();
    }

    public function createdBy()
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }

    protected function casts(): array
    {
        return [
            'start_date' => 'datetime',
            'end_date'   => 'datetime',
            'status'     => 'boolean',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('status', true)
            ->where('start_date', '<=', now())
            ->where(function ($q) {
                $q->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            });
    }
}

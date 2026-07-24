<?php

namespace App\Models\Marketing;

use App\Models\Core\Employee;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['advertisement_id', 'discount_percentage', 'offerable_id', 'offerable_type', 'old_price', 'new_price', 'start_date', 'end_date', 'status', 'created_by'])]
class Offer extends Model
{
    use SoftDeletes;
    public function advertisement()
    {
        return $this->belongsTo(Advertisement::class, 'advertisement_id');
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

<?php

namespace App\Models\Sales;

use App\Enums\TransactionCategory;
use App\Models\Core\Employee;
use App\Models\Core\Warehouse;
use App\Models\RealEstate\Project;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'voucher_number',
    'type',
    'amount',
    'currency',
    'exchange_rate',
    'transactionable_type',
    'transactionable_id',
    'project_id',
    'warehouse_id',
    'party_type',
    'party_id',
    'category',
    'payment_method',
    'status',
    'description',
    'created_by',
])]

class Transaction extends Model
{
    use SoftDeletes;

    protected function casts(): array
    {
        return [
            'category' => TransactionCategory::class,
        ];
    }

    public function transactionable()
    {
        return $this->morphTo();
    }

    public function party()
    {
        return $this->morphTo();
    }

    public function creator()
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }
}

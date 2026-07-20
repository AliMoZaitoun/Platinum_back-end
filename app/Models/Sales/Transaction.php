<?php

namespace App\Models\Sales;

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
}

<?php

namespace App\Models\Finance;

use App\Models\BaseModel;
use App\Models\Core\Employee;
use App\Models\Legal\Contract;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(
    [
        'contract_id',
        'requested_by',
        'action_by',
        'original_total_price',
        'requested_total_price',
        'original_down_payment',
        'requested_down_payment',
        'original_installments_count',
        'requested_installments_count',
        'reason',
        'rejection_reason',
        'status',
    ]
)]
class ContractException extends BaseModel
{
    use HasFactory;


    protected function casts(): array
    {
        return [
            'original_total_price'         => 'decimal:2',
            'requested_total_price'        => 'decimal:2',
            'original_down_payment'        => 'double',
            'requested_down_payment'       => 'double',
            'original_installments_count'  => 'integer',
            'requested_installments_count' => 'integer',
        ];
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function requester()
    {
        return $this->belongsTo(Employee::class, 'requested_by');
    }

    public function reviewer()
    {
        return $this->belongsTo(Employee::class, 'action_by');
    }
}

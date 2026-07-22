<?php

namespace App\Models\Sales;

use App\Models\Client\Client;
use App\Models\Core\Employee;
use App\Models\Media;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['contract_id', 'client_id', 'employee_id', 'amount', 'payment_date', 'payment_method', 'payment_type', 'status'])]
class Payment extends Model
{
    use SoftDeletes;
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function attachments()
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }
}

<?php

namespace App\Models\Sales;

use App\Models\Client\Client;
use App\Models\Core\Employee;
use App\Models\Media;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['order_id', 'employee_id', 'client_id', 'total_price', 'down_payment_amount', 'installments_count', 'status'])]
class Contract extends Model
{
    use SoftDeletes;
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function attachments()
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}

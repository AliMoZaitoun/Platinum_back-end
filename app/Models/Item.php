<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable('warehouse_id', 'sku', 'name', 'description', 'quantity', 'status', 'expiry_date', 'purchase_date', 'received_date')]
class Item extends Model
{
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}

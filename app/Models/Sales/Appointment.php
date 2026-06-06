<?php

namespace App\Models\Sales;

use App\Models\Client\Client;
use App\Models\Engineer\Engineer;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['order_id', 'av_slot_id', 'client_id', 'created_by_id', 'created_by_type', 'status'])]
class Appointment extends Model
{
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function slot()
    {
        return $this->belongsTo(AvailabilitySlot::class, 'av_slot_id');
    }

    public function createdBy()
    {
        return $this->morphTo();
    }
}

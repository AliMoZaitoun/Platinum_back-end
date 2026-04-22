<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['order_id', 'av_slot_id', 'client_id', 'created_by', 'status'])]
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

    public function createdBy()
    {
        return $this->belongsTo(Engineer::class, 'created_by');
    }

    public function av_slots()
    {
        return $this->hasMany(AvailabilitySlot::class, 'av_slot_id');
    }
}

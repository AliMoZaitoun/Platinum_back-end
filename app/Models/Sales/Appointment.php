<?php

namespace App\Models\Sales;

use App\Enums\AppointmentType;
use App\Models\Client\Client;
use App\Models\Engineer\Engineer;
use App\Models\Note;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['order_id', 'av_slot_id', 'client_id', 'created_by_id', 'created_by_type', 'status', 'type'])]
class Appointment extends Model
{
    protected $casts = [
        'type' => AppointmentType::class,
    ];

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

    public function notes()
    {
        return $this->morphMany(Note::class, 'noteable');
    }
}

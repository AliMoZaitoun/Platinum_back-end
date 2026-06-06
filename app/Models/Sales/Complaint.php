<?php

namespace App\Models\Sales;

use App\Models\Client\Client;
use App\Models\Media;
use App\Models\RealEstate\Unit;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['client_id', 'unit_id', 'complaint_type_id', 'title', 'body', 'status'])]
class Complaint extends Model
{
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function type()
    {
        return $this->belongsTo(ComplaintType::class, 'complaint_type_id');
    }

    public function attachments()
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}

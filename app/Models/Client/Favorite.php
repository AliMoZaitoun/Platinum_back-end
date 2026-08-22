<?php

namespace App\Models\Client;

use App\Models\RealEstate\Unit;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Support\LogOptions;

#[Fillable(['client_id', 'unit_id'])]
class Favorite extends BaseModel
{
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->dontLogIfAttributesChangedOnly(['*']);
    }
}

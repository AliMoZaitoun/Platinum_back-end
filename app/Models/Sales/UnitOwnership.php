<?php

namespace App\Models\Sales;

use App\Models\Client\Client;
use App\Models\Legal\Contract;
use App\Models\Media;
use App\Models\RealEstate\Unit;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['client_id', 'unit_id', 'contract_id', 'purchase_price', 'status', 'owned_at'])]
class UnitOwnership extends BaseModel
{
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function attachments()
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}

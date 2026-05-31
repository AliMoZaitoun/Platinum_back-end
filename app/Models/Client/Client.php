<?php

namespace App\Models\Client;

use App\Models\RealEstate\Unit;
use App\Models\Sales\Order;
use App\Models\Sales\UnitOwnership;
use App\Models\User;
use App\Models\V1\Sales\Complaint;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['user_id', 'birth_date', 'job_title', 'social_status', 'national_id'])]

class Client extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function attachments()
    {
        return $this->morphMany(Client::class, 'mediable');
    }

    public function ownerships()
    {
        return $this->hasMany(UnitOwnership::class, 'client_id');
    }

    public function units()
    {
        return $this->hasManyThrough(
            Unit::class,
            UnitOwnership::class,
            'client_id',
            'id',
            'id',
            'unit_id'
        );
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }
}

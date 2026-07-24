<?php

namespace App\Models\RealEstate;

use App\Models\Client\Client;
use App\Models\Client\Favorite;
use App\Models\Marketing\Offer;
use App\Models\Media;
use App\Models\Sales\Complaint;
use App\Models\Sales\Order;
use App\Models\Sales\UnitOwnership;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

#[Fillable([
    'building_id',
    'unit_number',
    'description',
    'type',
    'floor',
    'area',
    'rooms_count',
    'price',
    'status',
    'start_date',
    'end_date'
])]

class Unit extends Model
{
    use HasTranslations, SoftDeletes;

    public $translatable = ['description'];

    protected function casts(): array
    {
        return [
            'description' => 'array',
        ];
    }

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function attachments()
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function ownership()
    {
        return $this->hasMany(UnitOwnership::class, 'unit_id');
    }

    public function client()
    {
        return $this->hasOneThrough(
            Client::class,
            UnitOwnership::class,
            'unit_id',
            'id',
            'id',
            'client_id'
        );
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }

    public function offerable()
    {
        return $this->morphMany(Offer::class, 'offerable');
    }

    public function activeOffer()
    {
        return $this->morphOne(Offer::class, 'offerable')
            ->where('status', true)
            ->where('start_date', '<=', now())
            ->where(function ($q) {
                $q->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            });
    }

    public function getCurrentPriceAttribute()
    {
        return $this->activeOffer ? $this->activeOffer->new_price : $this->price;
    }

    public function getHasActiveOfferAttribute(): bool
    {
        return $this->activeOffer !== null;
    }

    public function getDiscountPercentageAttribute()
    {
        return $this->activeOffer ? $this->activeOffer->discount_percentage : 0;
    }
}

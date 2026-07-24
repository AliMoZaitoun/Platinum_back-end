<?php

namespace App\Models\RealEstate;

use App\Models\Marketing\Offer;
use App\Models\Media;
use App\Models\Sales\Order;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

#[Fillable(['name', 'description', 'price'])]
class Solution extends Model
{
    use HasTranslations, SoftDeletes;

    public $translatable = ['name', 'description'];

    protected function casts(): array
    {
        return [
            'name' => 'array',
            'description' => 'array',
        ];
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function attachments()
    {
        return $this->morphMany(Media::class, 'mediable');
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

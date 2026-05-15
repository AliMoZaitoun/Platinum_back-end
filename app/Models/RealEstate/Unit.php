<?php

namespace App\Models\RealEstate;

use App\Models\Sales\Order;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

#[Fillable(['building_id', 'unit_number', 'description', 'type', 'floor', 'area', 'rooms_count', 'price', 'status'])]
class Unit extends Model
{
    use HasTranslations;

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

    public function getLocationAttribute($value)
    {
        return $value ?? $this->building->location;
    }
}

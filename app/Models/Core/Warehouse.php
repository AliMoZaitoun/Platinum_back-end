<?php

namespace App\Models\Core;

use App\Models\RealEstate\Location;
use App\Models\Sales\Transaction;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

#[Fillable(['name', 'description', 'location_id', 'address'])]
class Warehouse extends Model
{
    use HasTranslations;

    public $translatable = ['name', 'description'];

    protected function casts(): array
    {
        return [
            'name' => 'array',
            'description' => 'array'
        ];
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}

<?php

namespace App\Models\RealEstate;

use App\Models\Sales\Order;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

#[Fillable(['name', 'description', 'price'])]
class Solution extends Model
{
    use HasTranslations;
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
}

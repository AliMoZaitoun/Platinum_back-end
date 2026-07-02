<?php

namespace App\Models\Core;

use App\Models\Sales\Order;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

#[Fillable(['name', 'description'])]
class Department extends Model
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

    public function employees()
    {
        return $this->hasMany(EmployeeDepartment::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}

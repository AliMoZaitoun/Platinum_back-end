<?php

namespace App\Models\Sales;

use App\Models\Client\Client;
use App\Models\RealEstate\Solution;
use App\Models\RealEstate\Unit;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['client_id', 'unit_id', 'solution_id', 'status'])]
class Order extends Model
{
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function solution()
    {
        return $this->belongsTo(Solution::class);
    }
}

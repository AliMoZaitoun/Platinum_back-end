<?php

namespace Database\Seeders;

use App\Models\Unit;
use App\Models\Building;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    public function run()
    {
        $building = Building::first();

        Unit::create([
            'building_id' => $building->id,
            'unit_number' => 'VIP-101',
            'floor' => 5,
            'rooms_count' => 4,
            'area' => 180.5,
            'type' => 'vip',
            'price' => 750000000.00,
            'status' => 'available',
        ]);

        Unit::create([
            'building_id' => $building->id,
            'unit_number' => 'B1-F5-U10',
            'floor' => 5,
            'rooms_count' => 3,
            'area' => 125.5,
            'type' => 'vip',
            'price' => 250000.00,
            'status' => 'available',
        ]);

        Unit::create([
            'building_id' => $building->id,
            'unit_number' => 'SOC-202',
            'floor' => 2,
            'rooms_count' => 3,
            'area' => 110.0,
            'type' => 'social',
            'price' => 320000000.00,
            'status' => 'reserved',
        ]);
    }
}

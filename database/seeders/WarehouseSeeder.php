<?php

namespace Database\Seeders;

use App\Models\Core\Warehouse;
use App\Models\RealEstate\Location;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    public function run(): void
    {
        $districts = Location::where('type', 'district')->get();

        $warehouses = [
            [
                'name'            => 'Main Documents Archive',
                'address'         => 'HQ Building, Floor B1 - Rotterdam, South Holland',
                'location_id'     => $districts->first()->id,
            ],
            [
                'name'     => 'Property Equipment Storage',
                'address' => 'Industrial Zone, Unit 4A - Rotterdam, South Holland',
                'location_id'     => $districts->first()->id,

            ],
            [
                'name'     => 'Furniture & Staging Depot',
                'address' => 'Logistics Park, Bay 12 - Schiedam, South Holland',
                'location_id'     => $districts->first()->id,

            ],
            [
                'name'     => 'Construction Materials Store',
                'address' => 'North Warehouse Complex, Block C - Delft, South Holland',
                'location_id'     => $districts->last()->id,

            ],
            [
                'name'     => 'IT & Office Equipment Store',
                'address' => 'HQ Building, Floor B2 - Rotterdam, South Holland',
                'location_id'     => $districts->last()->id,

            ],
        ];

        foreach ($warehouses as $warehouse) {
            Warehouse::create($warehouse);
        }
    }
}

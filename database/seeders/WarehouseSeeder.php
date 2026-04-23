<?php

namespace Database\Seeders;

use App\Models\Warehouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    public function run(): void
    {
        $warehouses = [
            [
                'name'     => 'Main Documents Archive',
                'location' => 'HQ Building, Floor B1 - Rotterdam, South Holland',
            ],
            [
                'name'     => 'Property Equipment Storage',
                'location' => 'Industrial Zone, Unit 4A - Rotterdam, South Holland',
            ],
            [
                'name'     => 'Furniture & Staging Depot',
                'location' => 'Logistics Park, Bay 12 - Schiedam, South Holland',
            ],
            [
                'name'     => 'Construction Materials Store',
                'location' => 'North Warehouse Complex, Block C - Delft, South Holland',
            ],
            [
                'name'     => 'IT & Office Equipment Store',
                'location' => 'HQ Building, Floor B2 - Rotterdam, South Holland',
            ],
        ];

        foreach ($warehouses as $warehouse) {
            Warehouse::create($warehouse);
        }
    }
}

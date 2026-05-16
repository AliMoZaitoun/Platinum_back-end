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
                'name'        => 'Main Documents Archive',
                'address'     => 'HQ Building, Floor B1 - Rotterdam, South Holland',
                'location_id' => $districts->first()->id,
                'description' => 'Secure, climate-controlled archive dedicated to storing original property deeds, blue prints, legal engineering contracts, and official project documentation.',
            ],
            [
                'name'        => 'Property Equipment Storage',
                'address'     => 'Industrial Zone, Unit 4A - Rotterdam, South Holland',
                'location_id' => $districts->first()->id,
                'description' => 'Central depot for real estate maintenance tools, site inspection gear, safety equipment, and machinery used by field engineers.',
            ],
            [
                'name'        => 'Furniture & Staging Depot',
                'address'     => 'Logistics Park, Bay 12 - Schiedam, South Holland',
                'location_id' => $districts->first()->id,
                'description' => 'Storage facility for interior design assets, staging furniture, and marketing materials used to prep luxury properties for open houses and client viewings.',
            ],
            [
                'name'        => 'Construction Materials Store',
                'address'     => 'North Warehouse Complex, Block C - Delft, South Holland',
                'location_id' => $districts->last()->id,
                'description' => 'Heavy-duty warehouse containing raw building materials, structural components, electrical supplies, and plumbing fixtures for ongoing real estate development projects.',
            ],
            [
                'name'        => 'IT & Office Equipment Store',
                'address'     => 'HQ Building, Floor B2 - Rotterdam, South Holland',
                'location_id' => $districts->last()->id,
                'description' => 'Internal tech repository for company hardware, including site computers, networking devices, plotters, and replacement office workstations for engineering teams.',
            ],
        ];

        foreach ($warehouses as $warehouse) {
            Warehouse::create($warehouse);
        }
    }
}

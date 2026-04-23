<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        $buildings = Building::with('project')->get()->keyBy(function ($b) {
            return $b->project->name . '|' . $b->building_number;
        });

        $units = [
            // -------------------------------------------------------
            // Maas Residences — Tower A
            // -------------------------------------------------------
            ['building' => 'Maas Residences|A', 'unit_number' => 'A-101',  'floor' => 1,  'area' => 72.5,  'price' => 385000, 'type' => 'social', 'status' => 'sold'],
            ['building' => 'Maas Residences|A', 'unit_number' => 'A-102',  'floor' => 1,  'area' => 68.0,  'price' => 365000, 'type' => 'social', 'status' => 'sold'],
            ['building' => 'Maas Residences|A', 'unit_number' => 'A-201',  'floor' => 2,  'area' => 72.5,  'price' => 390000, 'type' => 'social', 'status' => 'sold'],
            ['building' => 'Maas Residences|A', 'unit_number' => 'A-202',  'floor' => 2,  'area' => 68.0,  'price' => 370000, 'type' => 'social', 'status' => 'reserved'],
            ['building' => 'Maas Residences|A', 'unit_number' => 'A-501',  'floor' => 5,  'area' => 85.0,  'price' => 430000, 'type' => 'social', 'status' => 'available'],
            ['building' => 'Maas Residences|A', 'unit_number' => 'A-502',  'floor' => 5,  'area' => 85.0,  'price' => 430000, 'type' => 'social', 'status' => 'available'],
            ['building' => 'Maas Residences|A', 'unit_number' => 'A-1001', 'floor' => 10, 'area' => 110.0, 'price' => 580000, 'type' => 'vip',    'status' => 'available'],
            ['building' => 'Maas Residences|A', 'unit_number' => 'A-1801', 'floor' => 18, 'area' => 145.0, 'price' => 895000, 'type' => 'vip',    'status' => 'reserved'],

            // -------------------------------------------------------
            // Maas Residences — Tower B
            // -------------------------------------------------------
            ['building' => 'Maas Residences|B', 'unit_number' => 'B-101',  'floor' => 1,  'area' => 70.0,  'price' => 375000, 'type' => 'social', 'status' => 'sold'],
            ['building' => 'Maas Residences|B', 'unit_number' => 'B-301',  'floor' => 3,  'area' => 80.0,  'price' => 415000, 'type' => 'social', 'status' => 'available'],
            ['building' => 'Maas Residences|B', 'unit_number' => 'B-302',  'floor' => 3,  'area' => 80.0,  'price' => 415000, 'type' => 'social', 'status' => 'maintenance'],
            ['building' => 'Maas Residences|B', 'unit_number' => 'B-1801', 'floor' => 18, 'area' => 150.0, 'price' => 920000, 'type' => 'vip',    'status' => 'available'],

            // -------------------------------------------------------
            // Maas Residences — Tower C
            // -------------------------------------------------------
            ['building' => 'Maas Residences|C', 'unit_number' => 'C-101',  'floor' => 1,  'area' => 55.0,  'price' => 295000, 'type' => 'social', 'status' => 'sold'],
            ['building' => 'Maas Residences|C', 'unit_number' => 'C-102',  'floor' => 1,  'area' => 55.0,  'price' => 295000, 'type' => 'social', 'status' => 'sold'],
            ['building' => 'Maas Residences|C', 'unit_number' => 'C-601',  'floor' => 6,  'area' => 60.0,  'price' => 325000, 'type' => 'social', 'status' => 'available'],
            ['building' => 'Maas Residences|C', 'unit_number' => 'C-1201', 'floor' => 12, 'area' => 75.0,  'price' => 440000, 'type' => 'vip',    'status' => 'reserved'],

            // -------------------------------------------------------
            // Rotterdam Central Tower — mixed commercial/residential
            // -------------------------------------------------------
            ['building' => 'Rotterdam Central Tower|1', 'unit_number' => 'RCT-101',  'floor' => 1,  'area' => 120.0, 'price' => 650000,  'type' => 'social', 'status' => 'sold'],
            ['building' => 'Rotterdam Central Tower|1', 'unit_number' => 'RCT-102',  'floor' => 1,  'area' => 135.0, 'price' => 720000,  'type' => 'social', 'status' => 'sold'],
            ['building' => 'Rotterdam Central Tower|1', 'unit_number' => 'RCT-501',  'floor' => 5,  'area' => 200.0, 'price' => 1100000, 'type' => 'vip',    'status' => 'available'],
            ['building' => 'Rotterdam Central Tower|1', 'unit_number' => 'RCT-502',  'floor' => 5,  'area' => 200.0, 'price' => 1100000, 'type' => 'vip',    'status' => 'reserved'],
            ['building' => 'Rotterdam Central Tower|1', 'unit_number' => 'RCT-1001', 'floor' => 10, 'area' => 180.0, 'price' => 980000,  'type' => 'vip',    'status' => 'available'],
            ['building' => 'Rotterdam Central Tower|1', 'unit_number' => 'RCT-3201', 'floor' => 32, 'area' => 310.0, 'price' => 2500000, 'type' => 'vip',    'status' => 'available'],

            // -------------------------------------------------------
            // Kralingse Plas Garden Villas — North Block
            // -------------------------------------------------------
            ['building' => 'Kralingse Plas Garden Villas|Villa Block North', 'unit_number' => 'VN-01', 'floor' => 1, 'area' => 280.0, 'price' => 1450000, 'type' => 'vip', 'status' => 'sold'],
            ['building' => 'Kralingse Plas Garden Villas|Villa Block North', 'unit_number' => 'VN-02', 'floor' => 1, 'area' => 265.0, 'price' => 1380000, 'type' => 'vip', 'status' => 'available'],
            ['building' => 'Kralingse Plas Garden Villas|Villa Block North', 'unit_number' => 'VN-03', 'floor' => 1, 'area' => 270.0, 'price' => 1400000, 'type' => 'vip', 'status' => 'reserved'],

            // -------------------------------------------------------
            // Kralingse Plas Garden Villas — South Block
            // -------------------------------------------------------
            ['building' => 'Kralingse Plas Garden Villas|Villa Block South', 'unit_number' => 'VS-01', 'floor' => 1, 'area' => 255.0, 'price' => 1320000, 'type' => 'vip', 'status' => 'sold'],
            ['building' => 'Kralingse Plas Garden Villas|Villa Block South', 'unit_number' => 'VS-02', 'floor' => 1, 'area' => 260.0, 'price' => 1350000, 'type' => 'vip', 'status' => 'available'],

            // -------------------------------------------------------
            // Schiedam Harbor Lofts — Warehouse 1 (completed/all sold)
            // -------------------------------------------------------
            ['building' => 'Schiedam Harbor Lofts|Warehouse 1', 'unit_number' => 'WH1-101', 'floor' => 1, 'area' => 95.0,  'price' => 420000, 'type' => 'social', 'status' => 'sold'],
            ['building' => 'Schiedam Harbor Lofts|Warehouse 1', 'unit_number' => 'WH1-102', 'floor' => 1, 'area' => 90.0,  'price' => 400000, 'type' => 'social', 'status' => 'sold'],
            ['building' => 'Schiedam Harbor Lofts|Warehouse 1', 'unit_number' => 'WH1-301', 'floor' => 3, 'area' => 110.0, 'price' => 490000, 'type' => 'social', 'status' => 'sold'],
            ['building' => 'Schiedam Harbor Lofts|Warehouse 1', 'unit_number' => 'WH1-501', 'floor' => 5, 'area' => 140.0, 'price' => 680000, 'type' => 'vip',    'status' => 'sold'],

            // -------------------------------------------------------
            // Schiedam Harbor Lofts — Warehouse 2 (completed/mostly sold)
            // -------------------------------------------------------
            ['building' => 'Schiedam Harbor Lofts|Warehouse 2', 'unit_number' => 'WH2-101', 'floor' => 1, 'area' => 88.0,  'price' => 395000, 'type' => 'social', 'status' => 'sold'],
            ['building' => 'Schiedam Harbor Lofts|Warehouse 2', 'unit_number' => 'WH2-201', 'floor' => 2, 'area' => 92.0,  'price' => 415000, 'type' => 'social', 'status' => 'sold'],
            ['building' => 'Schiedam Harbor Lofts|Warehouse 2', 'unit_number' => 'WH2-501', 'floor' => 5, 'area' => 135.0, 'price' => 660000, 'type' => 'vip',    'status' => 'maintenance'],

            // -------------------------------------------------------
            // Delft Innovation Campus — Office Block Alpha (in_progress)
            // -------------------------------------------------------
            ['building' => 'Delft Innovation Campus|Office Block Alpha', 'unit_number' => 'DA-101', 'floor' => 1, 'area' => 250.0, 'price' => 950000,  'type' => 'social', 'status' => 'reserved'],
            ['building' => 'Delft Innovation Campus|Office Block Alpha', 'unit_number' => 'DA-201', 'floor' => 2, 'area' => 250.0, 'price' => 975000,  'type' => 'social', 'status' => 'available'],
            ['building' => 'Delft Innovation Campus|Office Block Alpha', 'unit_number' => 'DA-801', 'floor' => 8, 'area' => 400.0, 'price' => 1800000, 'type' => 'vip',    'status' => 'available'],

            // -------------------------------------------------------
            // Delft Innovation Campus — Office Block Beta (stopped)
            // -------------------------------------------------------
            ['building' => 'Delft Innovation Campus|Office Block Beta', 'unit_number' => 'DB-101', 'floor' => 1, 'area' => 200.0, 'price' => 780000, 'type' => 'social', 'status' => 'available'],
            ['building' => 'Delft Innovation Campus|Office Block Beta', 'unit_number' => 'DB-201', 'floor' => 2, 'area' => 200.0, 'price' => 800000, 'type' => 'social', 'status' => 'available'],

            // -------------------------------------------------------
            // Alexanderpolder Green Quarter — Green Block 1 (stopped)
            // -------------------------------------------------------
            ['building' => 'Alexanderpolder Green Quarter|Green Block 1', 'unit_number' => 'GB1-101', 'floor' => 1,  'area' => 65.0, 'price' => 310000, 'type' => 'social', 'status' => 'available'],
            ['building' => 'Alexanderpolder Green Quarter|Green Block 1', 'unit_number' => 'GB1-102', 'floor' => 1,  'area' => 65.0, 'price' => 310000, 'type' => 'social', 'status' => 'available'],
            ['building' => 'Alexanderpolder Green Quarter|Green Block 1', 'unit_number' => 'GB1-501', 'floor' => 5,  'area' => 80.0, 'price' => 390000, 'type' => 'social', 'status' => 'available'],
            ['building' => 'Alexanderpolder Green Quarter|Green Block 1', 'unit_number' => 'GB1-1001', 'floor' => 10, 'area' => 95.0, 'price' => 490000, 'type' => 'vip',    'status' => 'available'],

            // -------------------------------------------------------
            // Alexanderpolder Green Quarter — Green Block 2 (stopped)
            // -------------------------------------------------------
            ['building' => 'Alexanderpolder Green Quarter|Green Block 2', 'unit_number' => 'GB2-101', 'floor' => 1,  'area' => 65.0, 'price' => 310000, 'type' => 'social', 'status' => 'available'],
            ['building' => 'Alexanderpolder Green Quarter|Green Block 2', 'unit_number' => 'GB2-501', 'floor' => 5,  'area' => 78.0, 'price' => 385000, 'type' => 'social', 'status' => 'available'],
            ['building' => 'Alexanderpolder Green Quarter|Green Block 2', 'unit_number' => 'GB2-1001', 'floor' => 10, 'area' => 98.0, 'price' => 510000, 'type' => 'vip',    'status' => 'available'],
        ];

        foreach ($units as $unit) {
            $buildingKey = $unit['building'];
            unset($unit['building']);

            Unit::create([
                'building_id' => $buildings[$buildingKey]->id,
                ...$unit,
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\Project;
use Illuminate\Database\Seeder;

class BuildingSeeder extends Seeder
{
    public function run(): void
    {
        $projects = Project::all()->keyBy('name');

        $buildings = [
            // Maas Residences — 3 residential towers
            [
                'project_id'      => $projects['Maas Residences']->id,
                'building_number' => 'A',
                'floors_count'    => 18,
                'status'          => 'in_progress',
            ],
            [
                'project_id'      => $projects['Maas Residences']->id,
                'building_number' => 'B',
                'floors_count'    => 18,
                'status'          => 'in_progress',
            ],
            [
                'project_id'      => $projects['Maas Residences']->id,
                'building_number' => 'C',
                'floors_count'    => 12,
                'status'          => 'in_progress',
            ],

            // Rotterdam Central Tower — 1 mixed-use tower
            [
                'project_id'      => $projects['Rotterdam Central Tower']->id,
                'building_number' => '1',
                'floors_count'    => 32,
                'status'          => 'in_progress',
            ],

            // Kralingse Plas Garden Villas — villa clusters
            [
                'project_id'      => $projects['Kralingse Plas Garden Villas']->id,
                'building_number' => 'Villa Block North',
                'floors_count'    => 2,
                'status'          => 'in_progress',
            ],
            [
                'project_id'      => $projects['Kralingse Plas Garden Villas']->id,
                'building_number' => 'Villa Block South',
                'floors_count'    => 2,
                'status'          => 'in_progress',
            ],

            // Schiedam Harbor Lofts — completed project
            [
                'project_id'      => $projects['Schiedam Harbor Lofts']->id,
                'building_number' => 'Warehouse 1',
                'floors_count'    => 5,
                'status'          => 'completed',
            ],
            [
                'project_id'      => $projects['Schiedam Harbor Lofts']->id,
                'building_number' => 'Warehouse 2',
                'floors_count'    => 5,
                'status'          => 'completed',
            ],

            // Delft Innovation Campus — office blocks
            [
                'project_id'      => $projects['Delft Innovation Campus']->id,
                'building_number' => 'Office Block Alpha',
                'floors_count'    => 8,
                'status'          => 'in_progress',
            ],
            [
                'project_id'      => $projects['Delft Innovation Campus']->id,
                'building_number' => 'Office Block Beta',
                'floors_count'    => 6,
                'status'          => 'stopped',
            ],

            // Alexanderpolder Green Quarter — stopped project
            [
                'project_id'      => $projects['Alexanderpolder Green Quarter']->id,
                'building_number' => 'Green Block 1',
                'floors_count'    => 10,
                'status'          => 'stopped',
            ],
            [
                'project_id'      => $projects['Alexanderpolder Green Quarter']->id,
                'building_number' => 'Green Block 2',
                'floors_count'    => 10,
                'status'          => 'stopped',
            ],
        ];

        foreach ($buildings as $building) {
            Building::create($building);
        }
    }
}

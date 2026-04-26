<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\Project;
use Illuminate\Database\Seeder;

class BuildingSeeder extends Seeder
{
    public function run()
    {
        $project = Project::first();

        // إنشاء بناءين للمشروع الأول
        Building::create([
            'project_id' => $project->id,
            'location_id' => null, // يتبع موقع المشروع تلقائياً
            'building_number' => 'A-1',
            'floors_count' => 10,
            'status' => 'in_progress',
        ]);

        Building::create([
            'project_id' => $project->id,
            'location_id' => null,
            'building_number' => 'A-2',
            'floors_count' => 12,
            'status' => 'completed',
        ]);
    }
}

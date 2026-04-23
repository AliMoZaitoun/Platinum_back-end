<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'name'           => 'Maas Residences',
                'description'    => 'A premium waterfront residential development along the Maas river offering modern apartments with panoramic river views, underground parking, and high-end amenities.',
                'latitude'       => 51.9131,
                'longitude'      => 4.4662,
                'radius_meters'  => 350,
                'status'         => 'in_progress',
            ],
            [
                'name'           => 'Rotterdam Central Tower',
                'description'    => 'A mixed-use high-rise development adjacent to Rotterdam Centraal station, featuring commercial office floors, retail units on the ground level, and executive apartments.',
                'latitude'       => 51.9244,
                'longitude'      => 4.4690,
                'radius_meters'  => 120,
                'status'         => 'in_progress',
            ],
            [
                'name'           => 'Kralingse Plas Garden Villas',
                'description'    => 'A boutique gated community of luxury standalone villas surrounding the Kralingse Plas lake, offering private gardens, smart home systems, and lakeside access.',
                'latitude'       => 51.9281,
                'longitude'      => 4.5327,
                'radius_meters'  => 500,
                'status'         => 'in_progress',
            ],
            [
                'name'           => 'Schiedam Harbor Lofts',
                'description'    => 'Industrial-chic loft-style apartments developed inside a converted historic harbor warehouse in Schiedam. Unique open-plan layouts with original brick facades.',
                'latitude'       => 51.9188,
                'longitude'      => 4.4005,
                'radius_meters'  => 200,
                'status'         => 'completed',
            ],
            [
                'name'           => 'Delft Innovation Campus',
                'description'    => 'A commercial real estate development near TU Delft offering modern office spaces, co-working hubs, and R&D facilities designed for tech and engineering firms.',
                'latitude'       => 52.0022,
                'longitude'      => 4.3736,
                'radius_meters'  => 600,
                'status'         => 'in_progress',
            ],
            [
                'name'           => 'Alexanderpolder Green Quarter',
                'description'    => 'An eco-conscious residential project in the Alexanderpolder district featuring energy-efficient apartments, rooftop gardens, solar panels, and EV charging stations.',
                'latitude'       => 51.9492,
                'longitude'      => 4.5601,
                'radius_meters'  => 400,
                'status'         => 'stopped',
            ],
        ];
        foreach ($projects as $project) {
            Project::create($project);
        }
    }
}

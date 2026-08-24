<?php

namespace Database\Seeders;

use App\Models\RealEstate\Location;
use App\Models\RealEstate\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        $districts = Location::where('type', 'district')->get();
        if ($districts->isEmpty()) {
            $this->command->error('يرجى التأكد من وجود بيانات في جدول Locations أولاً!');
            return;
        }

        $projectsData = [
            [
                'name' => ['ar' => 'أبراج ماروتا سيتي - M1', 'en' => 'Marota City Towers - M1'],
                'description' => ['ar' => 'مشروع سكني فاخر ضمن المخطط التنظيمي الجديد لماروتا سيتي، يتميز بتصميم عصري وإطلالات مفتوحة.', 'en' => 'Luxury residential project within the new Marota City master plan, featuring modern design and open views.'],
                'latitude' => 33.49880000,
                'longitude' => 36.26250000,
                'status' => 'in_progress',
                'start_date' => Carbon::now()->subMonths(8)->format('Y-m-d'),
                'end_date' => Carbon::now()->addMonths(24)->format('Y-m-d')
            ],
            [
                'name' => ['ar' => 'مجمع يعفور ريزيدنس', 'en' => 'Yaafour Residence Complex'],
                'description' => ['ar' => 'مجمع فيلات وشقق سكنية راقية في منطقة يعفور، مزود بخدمات ذكية ومساحات خضراء واسعة.', 'en' => 'High-end villas and apartments complex in Yaafour area, equipped with smart services and wide green spaces.'],
                'latitude' => 33.53500000,
                'longitude' => 36.14000000,
                'status' => 'planned', // مشروع مخطط له
                'start_date' => Carbon::now()->addMonths(3)->format('Y-m-d'),
                'end_date' => null
            ],
            [
                'name' => ['ar' => 'تطوير القطاع الثالث - دمشق الجديدة', 'en' => 'Sector 3 Development - New Damascus'],
                'description' => ['ar' => 'مشروع إعادة إعمار وتطوير للبنى التحتية والمباني السكنية.', 'en' => 'Reconstruction and development project for infrastructure and residential buildings.'],
                'latitude' => 33.51100000,
                'longitude' => 36.28000000,
                'status' => 'in_progress',
                'start_date' => Carbon::now()->subMonths(14)->format('Y-m-d'),
                'end_date' => null
            ]
        ];

        foreach ($projectsData as $index => $data) {
            $locationId = $districts[$index % $districts->count()]->id;

            Project::create([
                'name'          => $data['name'],
                'description'   => $data['description'],
                'location_id'   => $locationId,
                'latitude'      => $data['latitude'],
                'longitude'     => $data['longitude'],
                'radius_meters' => rand(150, 400),
                'status'        => $data['status'],
                'start_date'    => $data['start_date'],
                'end_date'      => $data['end_date']
            ]);
        }
        $this->command->info('🎉 Damascus Projects seeded successfully!');
    }
}

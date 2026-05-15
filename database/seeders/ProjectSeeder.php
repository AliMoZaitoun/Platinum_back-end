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

        Project::create([
            'name' => [
                'ar' => 'برج الياسمين السكني',
                'en' => 'Al-Yasmin Residential Tower'
            ],
            'description' => [
                'ar' => 'مشروع سكني فاخر في قلب العاصمة مع إطلالة جبلية.',
                'en' => 'Luxury residential project in the heart of the capital with a mountain view.'
            ],
            'location_id'   => $districts->first()->id,
            'latitude'      => 33.51310000,
            'longitude'     => 36.24650000,
            'radius_meters' => 500,
            'status'        => 'in_progress',
            'start_date'    => '2024-12-08',
            'end_date'      => Carbon::now()
        ]);

        Project::create([
            'name' => [
                'ar' => 'مجمع ديار الشام',
                'en' => 'Diyar Al-Sham Complex'
            ],
            'description' => [
                'ar' => 'مجمع سكني تجاري متكامل الخدمات.',
                'en' => 'An integrated residential and commercial complex with full services.'
            ],
            'location_id'   => $districts->last()->id,
            'latitude'      => 33.52800000,
            'longitude'     => 36.21000000,
            'radius_meters' => 500,
            'status'        => 'stopped',
            'start_date'    => Carbon::now()
        ]);
    }
}

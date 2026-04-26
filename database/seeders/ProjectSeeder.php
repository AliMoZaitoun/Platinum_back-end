<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Location;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        // جلب الأحياء فقط للربط معها
        $districts = Location::where('type', 'district')->get();

        Project::create([
            'name' => 'برج الياسمين السكني',
            'description' => 'مشروع سكني فاخر في قلب العاصمة مع إطلالة جبلية.',
            'location_id' => $districts->first()->id, // المزة
            'latitude' => 33.51310000,
            'longitude' => 36.24650000,
            'radius_meters' => 500,
            'status' => 'in_progress',
        ]);

        Project::create([
            'name' => 'مجمع ديار الشام',
            'description' => 'مجمع سكني تجاري متكامل الخدمات.',
            'location_id' => $districts->last()->id, // مشروع دمر
            'latitude' => 33.52800000,
            'longitude' => 36.21000000,
            'radius_meters' => 1200,
            'status' => 'stopped',
        ]);
    }
}

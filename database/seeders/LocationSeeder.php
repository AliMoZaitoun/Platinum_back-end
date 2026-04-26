<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run()
    {
        // 1. الدولة
        $syria = Location::create([
            'name' => ['ar' => 'سوريا', 'en' => 'Syria'],
            'type' => 'country',
            'parent_id' => null,
        ]);

        // 2. المدن
        $damascus = Location::create([
            'name' => ['ar' => 'دمشق', 'en' => 'Damascus'],
            'type' => 'city',
            'parent_id' => $syria->id,
        ]);

        // 3. الأحياء
        $districts = [
            ['ar' => 'المزة', 'en' => 'Al-Mazza'],
            ['ar' => 'كفرسوسة', 'en' => 'Kفرسوسة'],
            ['ar' => 'مشروع دمر', 'en' => 'Project Dummar'],
        ];

        foreach ($districts as $district) {
            Location::create([
                'name' => $district,
                'type' => 'district',
                'parent_id' => $damascus->id,
            ]);
        }
    }
}

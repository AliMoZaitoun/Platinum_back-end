<?php

namespace Database\Seeders;

use App\Models\RealEstate\Building;
use App\Models\RealEstate\Project;
use Illuminate\Database\Seeder;

class BuildingSeeder extends Seeder
{
    public function run()
    {
        $projects = Project::take(2)->get();

        if ($projects->isEmpty()) {
            $this->command->error('يرجى تشغيل ProjectSeeder أولاً!');
            return;
        }

        $project1 = $projects->first();
        $project2 = $projects->last();

        Building::create([
            'project_id' => $project1->id,
            'location_id' => null,
            'building_number' => 'A-1',
            'floors_count' => 10,
            'status' => 'in_progress',
            'description' => [
                'ar' => 'المبنى الرئيسي السكني، قيد أعمال الإكساء الداخلي حالياً.',
                'en' => 'The main residential building, currently under interior cladding works.'
            ]
        ]);

        Building::create([
            'project_id' => $project1->id,
            'location_id' => null,
            'building_number' => 'A-2',
            'floors_count' => 12,
            'status' => 'completed',
            'description' => [
                'ar' => 'المبنى الثاني، تم الانتهاء من كافة الأعمال وهو جاهز للتسليم.',
                'en' => 'The second building, all works are completed and ready for handover.'
            ]
        ]);

        Building::create([
            'project_id' => $project1->id,
            'location_id' => null,
            'building_number' => 'B-1',
            'floors_count' => 8,
            'status' => 'planned',
            'description' => null
        ]);

        Building::create([
            'project_id' => $project2->id,
            'location_id' => null,
            'building_number' => 'C-Commercial',
            'floors_count' => 5,
            'status' => 'in_progress',
            'description' => [
                'ar' => 'المبنى التجاري المخصص للمحلات والعيادات والمكاتب.',
                'en' => 'The commercial building designated for shops, clinics, and offices.'
            ]
        ]);
    }
}

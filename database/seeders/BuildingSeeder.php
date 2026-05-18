<?php

namespace Database\Seeders;

use App\Models\RealEstate\Building;
use App\Models\RealEstate\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BuildingSeeder extends Seeder
{
    public function run()
    {
        $projects = Project::take(2)->get();
        if ($projects->isEmpty()) {
            $this->command->error('يرجى تشغيل ProjectSeeder أولاً!');
            return;
        }

        $disk = 's3';
        $project1 = $projects->first();
        $project2 = $projects->last();

        // 💡 قمنا بإضافة الإحداثيات والـ radius لكل بناء في مصفوفة البيانات
        $buildingsData = [
            [
                'project_id' => $project1->id,
                'number' => 'A-1',
                'floors' => 10,
                'status' => 'in_progress',
                'latitude' => $project1->latitude + 0.0002, // قريب من مركز المشروع 1
                'longitude' => $project1->longitude + 0.0002,
                'radius' => 80, // نصف قطر مخصص للحضور داخل البناء
                'desc' => ['ar' => 'المبنى الرئيسي السكني.', 'en' => 'The main residential building.']
            ],
            [
                'project_id' => $project1->id,
                'number' => 'A-2',
                'floors' => 12,
                'status' => 'completed',
                'latitude' => $project1->latitude - 0.0003, // قريب أيضاً
                'longitude' => $project1->longitude - 0.0001,
                'radius' => 80,
                'desc' => ['ar' => 'المبنى الثاني جاهز للتسليم.', 'en' => 'The second building ready for handover.']
            ],
            [
                'project_id' => $project1->id,
                'number' => 'B-1',
                'floors' => 8,
                'status' => 'planned',
                'latitude' => $project1->latitude + 0.0005,
                'longitude' => $project1->longitude - 0.0004,
                'radius' => 100,
                'desc' => null
            ],
            // 💡 مشروع 2 (يمثل حالة أبنية بأماكن مختلفة متباعدة عن مركز المشروع الأصلي)
            [
                'project_id' => $project2->id,
                'number' => 'C-Commercial',
                'floors' => 5,
                'status' => 'in_progress',
                'latitude' => $project2->latitude + 0.0150, // متباعد ومنفصل جغرافياً
                'longitude' => $project2->longitude + 0.0250,
                'radius' => 120, // نطاق مسموح أوسع للموقع التجاري
                'desc' => ['ar' => 'المبنى التجاري.', 'en' => 'The commercial building.']
            ]
        ];

        foreach ($buildingsData as $bData) {
            $building = Building::create([
                'project_id'      => $bData['project_id'],
                'location_id'     => null,
                'building_number' => $bData['number'],
                'floors_count'    => $bData['floors'],
                'status'          => $bData['status'],
                'description'     => $bData['desc'],
                // 💡 تخزين الحقول الجديدة في الداتابيز
                'latitude'        => $bData['latitude'],
                'longitude'       => $bData['longitude'],
                'radius_meters'   => $bData['radius'],
            ]);

            // رفع صورة واجهة لكل مبنى قيد الإنشاء أو جاهز
            if ($bData['status'] !== 'planned') {
                $imagePath = 'buildings/building_' . Str::random(5) . '.png';
                ob_start();
                $im = imagecreatetruecolor(400, 250);
                $bg = imagecolorallocate($im, 39, 174, 96); // Green
                imagefill($im, 0, 0, $bg);
                imagestring($im, 5, 20, 110, "Building: " . $bData['number'], imagecolorallocate($im, 255, 255, 255));
                imagepng($im);
                $imgContent = ob_get_clean();
                imagedestroy($im);

                try {
                    Storage::disk($disk)->put($imagePath, $imgContent, 'public');
                    $building->attachments()->create([
                        'uuid'          => (string) Str::uuid(),
                        'path'          => $imagePath,
                        'original_name' => 'facade_elevation.png',
                        'type'          => 'image',
                        'recorded_at'   => now(),
                    ]);
                } catch (\Exception $e) {
                    $this->command->error("Failed to upload building image: " . $e->getMessage());
                }
            }
        }
        $this->command->info('🎉 Buildings with Geo-coordinates seeded successfully!');
    }
}

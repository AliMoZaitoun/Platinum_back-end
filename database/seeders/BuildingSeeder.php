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
        $projects = Project::all();
        if ($projects->isEmpty()) {
            $this->command->error('يرجى تشغيل ProjectSeeder أولاً!');
            return;
        }

        $disk = 's3';
        $statuses = ['in_progress', 'completed', 'planned'];
        $prefixes = ['Block-A', 'Block-B', 'Block-C', 'Tower-X'];

        foreach ($projects as $project) {
            // توليد من 3 إلى 4 أبنية لكل مشروع
            $buildingsCount = rand(3, 4);

            for ($i = 1; $i <= $buildingsCount; $i++) {
                $status = $statuses[array_rand($statuses)];
                $buildingNumber = $prefixes[array_rand($prefixes)] . '-' . $i;

                // حساب إحداثيات قريبة جداً من مركز المشروع (إضافة فروقات بسيطة بالـ GPS)
                $latOffset = (rand(-5, 5) / 10000);
                $lngOffset = (rand(-5, 5) / 10000);

                // توليد تاريخ بداية عشوائي منطقي (خلال الـ 365 يوم الماضية)
                $startDate = now()->subDays(rand(1, 365))->format('Y-m-d');

                $building = Building::create([
                    'project_id'      => $project->id,
                    'location_id'     => null,
                    'building_number' => $buildingNumber,
                    'floors_count'    => rand(5, 14), // طوابق متنوعة بين 5 و 14
                    'status'          => $status,
                    'start_date'      => $startDate,
                    'end_date'        => null, // 👈 إضافة تاريخ الانتهاء كـ null ليكون الشغل متكامل
                    'description'     => [
                        'ar' => "المبنى رقم {$buildingNumber} التابع لمشروع {$project->getTranslation('name', 'ar')}.",
                        'en' => "Building {$buildingNumber} belonging to {$project->getTranslation('name', 'en')} project."
                    ],
                    'latitude'        => $project->latitude + $latOffset,
                    'longitude'       => $project->longitude + $lngOffset,
                    'radius_meters'   => rand(60, 100),
                ]);

                if ($status !== 'planned') {
                    $imagePath = 'buildings/building_' . Str::random(5) . '.png';
                    ob_start();
                    $im = imagecreatetruecolor(400, 250);
                    $bg = imagecolorallocate($im, 39, 174, 96);
                    imagefill($im, 0, 0, $bg);
                    imagestring($im, 5, 20, 110, "Building: " . $buildingNumber, imagecolorallocate($im, 255, 255, 255));
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
        }
        $this->command->info('🎉 Buildings seeded dynamically with start and end dates!');
    }
}

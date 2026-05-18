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

        $buildingsData = [
            ['project_id' => $project1->id, 'number' => 'A-1', 'floors' => 10, 'status' => 'in_progress', 'desc' => ['ar' => 'المبنى الرئيسي السكني.', 'en' => 'The main residential building.']],
            ['project_id' => $project1->id, 'number' => 'A-2', 'floors' => 12, 'status' => 'completed', 'desc' => ['ar' => 'المبنى الثاني جاهز للتسليم.', 'en' => 'The second building ready for handover.']],
            ['project_id' => $project1->id, 'number' => 'B-1', 'floors' => 8, 'status' => 'planned', 'desc' => null],
            ['project_id' => $project2->id, 'number' => 'C-Commercial', 'floors' => 5, 'status' => 'in_progress', 'desc' => ['ar' => 'المبنى التجاري.', 'en' => 'The commercial building.']]
        ];

        foreach ($buildingsData as $bData) {
            $building = Building::create([
                'project_id'      => $bData['project_id'],
                'location_id'     => null,
                'building_number' => $bData['number'],
                'floors_count'    => $bData['floors'],
                'status'          => $bData['status'],
                'description'     => $bData['desc']
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
    }
}

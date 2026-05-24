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

        $disk = 's3';
        $prefixes = ['Block-A', 'Block-B', 'Block-C', 'Tower-X'];

        foreach ($projects as $project) {
            $buildingsCount = rand(3, 4);

            for ($i = 1; $i <= $buildingsCount; $i++) {
                $buildingNumber = $prefixes[array_rand($prefixes)] . '-' . $i;

                if ($project->status === 'planned') {
                    $status = 'planned';
                } elseif ($project->status === 'stopped') {
                    $status = 'stopped';
                } else {
                    $status = array_rand(['in_progress' => 0, 'planned' => 1]);
                    $status = rand(0, 1) === 0 ? 'in_progress' : 'planned';
                }

                $latOffset = (rand(-5, 5) / 10000);
                $lngOffset = (rand(-5, 5) / 10000);

                $startDate = $status === 'planned'
                    ? now()->addMonths(rand(1, 6))->format('Y-m-d')
                    : now()->subDays(rand(1, 365))->format('Y-m-d');

                $building = Building::create([
                    'project_id'      => $project->id,
                    'location_id'     => null,
                    'building_number' => $buildingNumber,
                    'floors_count'    => rand(5, 14),
                    'status'          => $status,
                    'start_date'      => $startDate,
                    'end_date'        => null,
                    'description'     => [
                        'ar' => "المبنى رقم {$buildingNumber} التابع لمشروع {$project->getTranslation('name', 'ar')}.",
                        'en' => "Building {$buildingNumber} belonging to {$project->getTranslation('name', 'en')} project."
                    ],
                    'latitude'        => $project->latitude + $latOffset,
                    'longitude'       => $project->longitude + $lngOffset,
                    'radius_meters'   => rand(60, 100),
                ]);

                if ($status === 'in_progress' || $status === 'completed') {
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
        $this->command->info('🎉 Buildings seeded logically and perfectly aligned with projects!');
    }
}

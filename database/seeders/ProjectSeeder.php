<?php

namespace Database\Seeders;

use App\Models\RealEstate\Location;
use App\Models\RealEstate\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        $districts = Location::where('type', 'district')->get();
        if ($districts->isEmpty()) {
            $this->command->error('يرجى التأكد من وجود بيانات في جدول Locations أولاً!');
            return;
        }

        $disk = 's3';

        $projectsData = [
            [
                'name' => ['ar' => 'برج الياسمين السكني', 'en' => 'Al-Yasmin Residential Tower'],
                'description' => ['ar' => 'مشروع سكني فاخر في قلب العاصمة مع إطلالة جبلية.', 'en' => 'Luxury residential project in the heart of the capital with a mountain view.'],
                'latitude' => 33.51310000,
                'longitude' => 36.24650000,
                'status' => 'in_progress',
                'start_date' => '2024-12-08',
                'end_date' => Carbon::now()
            ],
            [
                'name' => ['ar' => 'مجمع ديار الشام', 'en' => 'Diyar Al-Sham Complex'],
                'description' => ['ar' => 'مجمع سكني تجاري متكامل الخدمات.', 'en' => 'An integrated residential and commercial complex with full services.'],
                'latitude' => 33.52800000,
                'longitude' => 36.21000000,
                'status' => 'stopped',
                'start_date' => Carbon::now(),
                'end_date' => null
            ],
            [
                'name' => ['ar' => 'واحة دمشق الذكية', 'en' => 'Damascus Smart Oasis'],
                'description' => ['ar' => 'مشروع سكني يعتمد على تقنيات الطاقة البديلة والذكاء الاصطناعي.', 'en' => 'A residential project relying on alternative energy and AI technologies.'],
                'latitude' => 33.50120000,
                'longitude' => 36.29110000,
                'status' => 'planned',
                'start_date' => Carbon::now()->addMonths(2),
                'end_date' => null
            ]
        ];

        foreach ($projectsData as $index => $data) {
            // توزيع المشاريع على المناطق الموجودة بالتناوب
            $locationId = $districts[$index % $districts->count()]->id;

            $project = Project::create([
                'name'          => $data['name'],
                'description'   => $data['description'],
                'location_id'   => $locationId,
                'latitude'      => $data['latitude'],
                'longitude'     => $data['longitude'],
                'radius_meters' => 600,
                'status'        => $data['status'],
                'start_date'    => $data['start_date'],
                'end_date'      => $data['end_date']
            ]);

            $imagePath = 'projects/project_' . Str::random(5) . '.png';
            $imageContent = $this->generateDummyImage("Project: " . $data['name']['en']);

            try {
                Storage::disk($disk)->put($imagePath, $imageContent, 'public');
                $project->attachments()->create([
                    'uuid'          => (string) Str::uuid(),
                    'path'          => $imagePath,
                    'original_name' => 'project_master_plan.png',
                    'type'          => 'image',
                    'recorded_at'   => now(),
                ]);
            } catch (\Exception $e) {
                $this->command->error("Failed uploading project image: " . $e->getMessage());
            }
        }
        $this->command->info('🎉 Projects seeded successfully!');
    }

    private function generateDummyImage($text)
    {
        ob_start();
        $im = imagecreatetruecolor(400, 250);
        $bg = imagecolorallocate($im, 41, 128, 185);
        imagefill($im, 0, 0, $bg);
        $text_color = imagecolorallocate($im, 255, 255, 255);
        imagestring($im, 5, 20, 110, $text, $text_color);
        imagepng($im);
        $content = ob_get_clean();
        imagedestroy($im);
        return $content;
    }
}

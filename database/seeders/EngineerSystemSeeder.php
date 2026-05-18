<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Engineer\Engineer;
// 💡 تم تعديل اسم الموديل هنا
use App\Models\Engineer\ProjectEngineerAllocation;
use App\Models\Engineer\Attendance;
use App\Models\RealEstate\Project;
use App\Models\Engineer\ConstructionReport;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class EngineerSystemSeeder extends Seeder
{
    public function run(): void
    {
        $disk = 's3';

        $dummyFilePath = 'reports/dummy_blueprint_report_' . Str::random(5) . '.pdf';
        $pdfContent = '%PDF-1.5 ... Dummy Engineering Report Content ...';

        try {
            Storage::disk($disk)->put($dummyFilePath, $pdfContent, 'public');
            $this->command->info("🎉 Success: Dummy PDF uploaded to Supabase Storage at: {$dummyFilePath}");
        } catch (\Exception $e) {
            $this->command->error("❌ Failed to upload PDF to Supabase: " . $e->getMessage());
        }

        $dummyImagePath = 'buildings/dummy_building_' . Str::random(5) . '.png';

        ob_start();
        $im = imagecreatetruecolor(200, 200);
        $text_color = imagecolorallocate($im, 255, 255, 255);
        imagestring($im, 5, 50, 90, "Test Image", $text_color);
        imagepng($im);
        $imageContent = ob_get_clean();
        imagedestroy($im);

        try {
            Storage::disk($disk)->put($dummyImagePath, $imageContent, 'public');
            $this->command->info("🎉 Success: Dummy Image uploaded to Supabase Storage at: {$dummyImagePath}");
        } catch (\Exception $e) {
            $this->command->error("❌ Failed to upload Image to Supabase: " . $e->getMessage());
        }

        $projects = Project::with('buildings')->get();
        if ($projects->isEmpty()) {
            $this->command->warn('Please seed Projects and Buildings first to link engineers properly!');
            return;
        }

        $engineersData = [
            [
                'user' => [
                    'first_name' => 'Tommy',
                    'last_name' => 'Shelby',
                    'email' => 'ts@eng.com',
                    'phone' => '+963911111111',
                    'address' => 'Damascus, Syria',
                    'gender' => 'male',
                    'type' => 'engineer',
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ],
                'profile' => [
                    'specialization' => 'Civil Engineering',
                    'experience_years' => 4,
                ]
            ]
        ];

        foreach ($engineersData as $data) {
            $user = User::create($data['user']);

            $engineer = Engineer::create([
                'user_id' => $user->id,
                'specialization' => $data['profile']['specialization'],
                'experience_years' => $data['profile']['experience_years'],
            ]);
            $user->assignRole('engineer');

            $project = $projects->random();
            $buildings = $project->buildings;

            if ($buildings->isNotEmpty()) {
                foreach ($buildings as $building) {
                    ProjectEngineerAllocation::create([
                        'engineer_id' => $engineer->id,
                        'project_id'  => $project->id,
                        'building_id' => $building->id,
                        'start_date'  => Carbon::now()->subMonths(2)->format('Y-m-d'),
                        'end_date'    => Carbon::now()->addMonths(6)->format('Y-m-d'),
                    ]);
                }
                $targetBuildingId = $buildings->first()->id;
            } else {
                ProjectEngineerAllocation::create([
                    'engineer_id' => $engineer->id,
                    'project_id'  => $project->id,
                    'building_id' => null,
                    'start_date'  => Carbon::now()->subMonths(2)->format('Y-m-d'),
                    'end_date'    => Carbon::now()->addMonths(6)->format('Y-m-d'),
                ]);
                $targetBuildingId = null;
            }

            Attendance::create([
                'uuid' => (string) Str::uuid(),
                'engineer_id' => $engineer->id,
                'project_id' => $project->id,
                'building_id' => $targetBuildingId,
                'check_in_lat' => (string) ($project->latitude + 0.0001),
                'check_in_lng' => (string) ($project->longitude + 0.0001),
                'check_out_lat' => (string) ($project->latitude - 0.0001),
                'check_out_lng' => (string) ($project->longitude - 0.0001),
                'device_id' => 'iPhone_15_Pro_Max_Test_Device',
                'checked_in_at' => Carbon::now()->setTime(8, 0, 0)->format('Y-m-d H:i:s'),
                'checked_out_at' => Carbon::now()->setTime(16, 30, 0)->format('Y-m-d H:i:s'),
                'total_hours' => 8.5,
            ]);

            $report = ConstructionReport::create([
                'uuid'                  => (string) Str::uuid(),
                'project_id'            => $project->id,
                'building_id'           => $targetBuildingId,
                'engineer_id'           => $engineer->id,
                'phase'                 => 'foundation',
                'completion_percentage' => 45.50,
                'daily_progress'        => 3.25,
                'status'                => 'on_track',
                'manpower_count'        => 14,
                'issues_count'          => 0,
                'report_date'           => Carbon::now()->format('Y-m-d H:i:s'),
                'recorded_at'           => Carbon::now()->format('Y-m-d H:i:s'),
                'description'           => 'Completed concrete pouring for Block A foundation.',
            ]);

            $report->media()->create([
                'uuid'          => (string) Str::uuid(),
                'path'          => $dummyImagePath,
                'original_name' => 'site_blueprint_v1.png',
                'type'          => 'image',
                'recorded_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'custom_properties' => json_encode([
                    'file_size' => '12KB',
                    'uploaded_by' => 'System Seeder'
                ]),
            ]);
        }

        $this->command->info('🎉 Project Engineer Allocations, Attendances, and Progress Reports seeded successfully!');
    }
}

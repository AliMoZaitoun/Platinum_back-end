<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Engineer\Engineer;
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

            // =================================================================
            // 🔥 تعديل حنش وعلي: صناعة سيناريو متسق ومتكامل (الحضور + التقارير) لآخر 7 أيام
            // =================================================================
            $this->command->info("🏗️ Seeding 7 days of historical Data (Attendance & Matching Reports) for testing analytics...");

            // مصفوفة السيناريو التراكمي (تكدس عمال بآخر 3 أيام مع انهيار الإنتاجية)
            $sevenDaysScenario = [
                // أول 4 أيام (الفترة الأولى - وضع ممتاز وعمال قليل)
                ['days_back' => 6, 'manpower' => 10, 'progress' => 4.5, 'status' => 'on_track'],
                ['days_back' => 5, 'manpower' => 11, 'progress' => 4.8, 'status' => 'on_track'],
                ['days_back' => 4, 'manpower' => 10, 'progress' => 5.0, 'status' => 'on_track'],
                ['days_back' => 3, 'manpower' => 12, 'progress' => 4.2, 'status' => 'on_track'],

                // آخر 3 أيام (الفترة الثانية - تكدس العمال وتراجع حاد بإنتاجية الفرد)
                ['days_back' => 2, 'manpower' => 35, 'progress' => 2.1, 'status' => 'on_track'],
                ['days_back' => 1, 'manpower' => 38, 'progress' => 1.5, 'status' => 'on_track'],
                ['days_back' => 0, 'manpower' => 40, 'progress' => 1.0, 'status' => 'on_track'], // اليوم الحالي: ذروة التكدس
            ];

            $cumulativePercentage = 20.00; // نسبة بداية المرحلة الإنشائية

            foreach ($sevenDaysScenario as $day) {
                // تحديد تاريخ اليوم الفعلي بقلب الحلقة
                $currentLoopDate = Carbon::now()->subDays($day['days_back']);
                $cumulativePercentage += $day['progress'];

                // 1️⃣ أولاً: تسجيل حضور للمهندس بنفس اليوم (عشان نتجاوز قفل الـ Validation بالـ Service)
                Attendance::create([
                    'uuid' => (string) Str::uuid(),
                    'engineer_id' => $engineer->id,
                    'project_id' => $project->id,
                    'building_id' => $targetBuildingId,
                    'check_in_lat' => (string) ($project->latitude + 0.0001),
                    'check_in_lng' => (string) ($project->longitude + 0.0001),
                    'check_out_lat' => null, // منخليه null عشان نضمن إنه لسه مسجل حضور ولم يخرج أثناء رفع التقرير
                    'device_id' => 'iPhone_15_Pro_Max_Test_Device',
                    'checked_in_at' => $currentLoopDate->copy()->setTime(8, 0, 0)->format('Y-m-d H:i:s'),
                    'checked_out_at' => null,
                    'total_hours' => 0,
                ]);

                // 2️⃣ ثانياً: إنشاء تقرير الإنجاز اليومي المتطابق مع تاريخ الحضور
                $report = ConstructionReport::create([
                    'uuid'                  => (string) Str::uuid(),
                    'project_id'            => $project->id,
                    'building_id'           => $targetBuildingId,
                    'engineer_id'           => $engineer->id,
                    'phase'                 => 'foundation', // نفس المرحلة لضمان صحة التجميع التاريخي بالـ SQL
                    'completion_percentage' => $cumulativePercentage,
                    'daily_progress'        => $day['progress'],
                    'status'                => $day['status'],
                    'manpower_count'        => $day['manpower'],
                    'issues_count'          => 0,
                    'report_date'           => $currentLoopDate->format('Y-m-d H:i:s'),
                    'recorded_at'           => $currentLoopDate->format('Y-m-d H:i:s'),
                    'description'           => "Simulated report for day minus {$day['days_back']} with {$day['manpower']} workers.",
                ]);

                // ربط المرفق بالتقرير الأخير فقط (توفيراً لمساحة الـ Storage بالتجريب)
                if ($day['days_back'] === 0) {
                    $report->attachments()->create([
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
            }
        }

        $this->command->info('🎉 Project Engineer Allocations, Attendances, and Progress Reports seeded successfully!');
    }
}

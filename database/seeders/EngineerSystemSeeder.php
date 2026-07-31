<?php

namespace Database\Seeders;

use App\Jobs\V1\RealEstate\Analysis\AnalyzeLaborProductivityJob;
use App\Models\Engineer\Attendance;
use App\Models\Engineer\ConstructionReport;
use App\Models\Engineer\Engineer;
use App\Models\Engineer\ProjectEngineerAllocation;
use App\Models\RealEstate\Building;
use App\Models\RealEstate\Project;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EngineerSystemSeeder extends Seeder
{
    public function run(): void
    {
        $disk = 's3';

        // 1️⃣ رفع صورة وهمية كـ Test
        $dummyImagePath = 'buildings/dummy_building_' . Str::random(5) . '.png';
        ob_start();
        $im = imagecreatetruecolor(200, 200);
        $text_color = imagecolorallocate($im, 255, 255, 255);
        imagestring($im, 5, 50, 90, "Site Active", $text_color);
        imagepng($im);
        $imageContent = ob_get_clean();
        imagedestroy($im);

        try {
            Storage::disk($disk)->put($dummyImagePath, $imageContent, 'public');
        } catch (\Exception $e) {
            $this->command->error("❌ Upload Exception: " . $e->getMessage());
        }

        // 2️⃣ جلب المشاريع الشغالة مع أبنيتها
        $activeProjects = Project::where('status', 'in_progress')
            ->with(['buildings' => fn($q) => $q->where('status', 'in_progress')])
            ->get();

        if ($activeProjects->isEmpty()) {
            $this->command->error('❌ لا يوجد مشاريع بحالة in_progress! يرجى تشغيل ProjectSeeder أولاً.');
            return;
        }

        // 3️⃣ طاقم المهندسين
        $engineersData = [
            [
                'user' => [
                    'first_name' => 'Tommy',
                    'last_name'  => 'Shelby',
                    'email'      => 'ts@eng.com',
                    'phone'      => '+963911111111',
                    'address'    => 'Damascus',
                    'gender'     => 'male',
                    'type'       => 'engineer',
                    'password'   => Hash::make('password'),
                    'email_verified_at' => now(),
                ],
                'profile' => ['specialization' => 'Civil Engineering', 'experience_years' => 8],
                'allocation_type' => 'project_wide'
            ],
            [
                'user' => [
                    'first_name' => 'Arthur',
                    'last_name'  => 'Shelby',
                    'email'      => 'as@eng.com',
                    'phone'      => '+963922222222',
                    'address'    => 'Aleppo',
                    'gender'     => 'male',
                    'type'       => 'engineer',
                    'password'   => Hash::make('password'),
                    'email_verified_at' => now(),
                ],
                'profile' => ['specialization' => 'Architectural Engineering', 'experience_years' => 5],
                'allocation_type' => 'specific_building'
            ],
            [
                'user' => [
                    'first_name' => 'Ada',
                    'last_name'  => 'Thorne',
                    'email'      => 'at@eng.com',
                    'phone'      => '+963933333333',
                    'address'    => 'Homs',
                    'gender'     => 'female',
                    'type'       => 'engineer',
                    'password'   => Hash::make('password'),
                    'email_verified_at' => now(),
                ],
                'profile' => ['specialization' => 'Electrical Engineering', 'experience_years' => 4],
                'allocation_type' => 'multiple_buildings'
            ]
        ];

        // 🎯 4️⃣ تعريف السيناريوهات الثلاثة لتغطية كافة مستويات الخطورة (WARNING, DANGER, SUCCESS)

        // 🟡 سيناريو 1: الاكتظاظ وهبوط الإنتاجية (WARNING)
        $warningScenario = [
            ['days_back' => 6, 'manpower' => 10, 'progress' => 5.0, 'status' => 'on_track'],
            ['days_back' => 5, 'manpower' => 10, 'progress' => 5.2, 'status' => 'on_track'],
            ['days_back' => 4, 'manpower' => 12, 'progress' => 4.8, 'status' => 'on_track'],
            ['days_back' => 3, 'manpower' => 11, 'progress' => 5.1, 'status' => 'on_track'],
            ['days_back' => 2, 'manpower' => 30, 'progress' => 2.0, 'status' => 'on_track'],
            ['days_back' => 1, 'manpower' => 35, 'progress' => 1.5, 'status' => 'on_track'],
            ['days_back' => 0, 'manpower' => 40, 'progress' => 1.0, 'status' => 'on_track'],
        ];

        // 🔴 سيناريو 2: توقف وتجمّد العمل بالكامل رغم وجود عمالة (DANGER)
        $dangerScenario = [
            ['days_back' => 6, 'manpower' => 15, 'progress' => 4.0, 'status' => 'on_track'],
            ['days_back' => 5, 'manpower' => 15, 'progress' => 4.0, 'status' => 'on_track'],
            ['days_back' => 4, 'manpower' => 15, 'progress' => 3.5, 'status' => 'on_track'],
            ['days_back' => 3, 'manpower' => 15, 'progress' => 3.8, 'status' => 'on_track'],
            ['days_back' => 2, 'manpower' => 20, 'progress' => 0.0, 'status' => 'delayed'],
            ['days_back' => 1, 'manpower' => 20, 'progress' => 0.0, 'status' => 'delayed'],
            ['days_back' => 0, 'manpower' => 20, 'progress' => 0.0, 'status' => 'delayed'],
        ];

        // 🟢 سيناريو 3: قفزة وتسارع ممتاز بالإنتاجية (SUCCESS)
        $successScenario = [
            ['days_back' => 6, 'manpower' => 20, 'progress' => 2.0, 'status' => 'on_track'],
            ['days_back' => 5, 'manpower' => 20, 'progress' => 2.1, 'status' => 'on_track'],
            ['days_back' => 4, 'manpower' => 20, 'progress' => 1.9, 'status' => 'on_track'],
            ['days_back' => 3, 'manpower' => 20, 'progress' => 2.0, 'status' => 'on_track'],
            ['days_back' => 2, 'manpower' => 20, 'progress' => 6.0, 'status' => 'on_track'],
            ['days_back' => 1, 'manpower' => 20, 'progress' => 6.5, 'status' => 'on_track'],
            ['days_back' => 0, 'manpower' => 20, 'progress' => 7.0, 'status' => 'on_track'],
        ];

        $allScenarios = [$warningScenario, $dangerScenario, $successScenario];

        foreach ($engineersData as $index => $data) {
            $user = User::create($data['user']);
            if (method_exists($user, 'assignRole')) {
                $user->assignRole('engineer');
            }

            $engineer = Engineer::create([
                'user_id'          => $user->id,
                'specialization'   => $data['profile']['specialization'],
                'experience_years' => $data['profile']['experience_years'],
            ]);

            $project = $activeProjects[$index % $activeProjects->count()];
            $projectBuildings = $project->buildings;

            $allocations = [];

            if ($data['allocation_type'] === 'project_wide' || $projectBuildings->isEmpty()) {
                ProjectEngineerAllocation::create([
                    'engineer_id' => $engineer->id,
                    'project_id'  => $project->id,
                    'building_id' => null,
                    'start_date'  => now()->subMonths(1)->format('Y-m-d'),
                    'end_date'    => now()->addMonths(5)->format('Y-m-d'),
                ]);
                $allocations[] = null;
            } elseif ($data['allocation_type'] === 'specific_building') {
                $targetBuilding = $projectBuildings->first();
                ProjectEngineerAllocation::create([
                    'engineer_id' => $engineer->id,
                    'project_id'  => $project->id,
                    'building_id' => $targetBuilding->id,
                    'start_date'  => now()->subMonths(1)->format('Y-m-d'),
                    'end_date'    => now()->addMonths(5)->format('Y-m-d'),
                ]);
                $allocations[] = $targetBuilding->id;
            } elseif ($data['allocation_type'] === 'multiple_buildings') {
                foreach ($projectBuildings->take(2) as $building) {
                    ProjectEngineerAllocation::create([
                        'engineer_id' => $engineer->id,
                        'project_id'  => $project->id,
                        'building_id' => $building->id,
                        'start_date'  => now()->subMonths(1)->format('Y-m-d'),
                        'end_date'    => now()->addMonths(5)->format('Y-m-d'),
                    ]);
                    $allocations[] = $building->id;
                }
            }

            // اختيار السيناريو المناسب لهذا المهندس
            $currentScenario = $allScenarios[$index % count($allScenarios)];

            // =================================================================
            // 📊 إنشاء بيانات التواريخ والتقارير وتفعيل الـ Job التحليلي
            // =================================================================
            foreach ($allocations as $targetBuildingId) {
                $cumulativePercentage = 10.00;

                foreach ($currentScenario as $day) {
                    // توحيد تاريخ اليوم عند الساعة 10:00 صباحاً
                    $currentLoopDate = Carbon::now()->subDays($day['days_back'])->setTime(10, 0, 0);
                    $cumulativePercentage += $day['progress'];

                    // 1️⃣ سجل الحضور
                    Attendance::create([
                        'uuid'           => (string) Str::uuid(),
                        'engineer_id'    => $engineer->id,
                        'project_id'     => $project->id,
                        'building_id'    => $targetBuildingId,
                        'check_in_lat'   => (string) ($project->latitude ?? 33.5138),
                        'check_in_lng'   => (string) ($project->longitude ?? 36.2765),
                        'check_out_lat'  => (string) ($project->latitude ?? 33.5138),
                        'device_id'      => 'Device_' . Str::slug($user->first_name) . '_Test',
                        'checked_in_at'  => $currentLoopDate->copy()->setTime(8, 0, 0)->format('Y-m-d H:i:s'),
                        'checked_out_at' => $currentLoopDate->copy()->setTime(16, 30, 0)->format('Y-m-d H:i:s'),
                        'total_hours'    => 8.5,
                    ]);

                    // 2️⃣ التقرير الهندسي
                    $report = ConstructionReport::create([
                        'uuid'                  => (string) Str::uuid(),
                        'project_id'            => $project->id,
                        'building_id'           => $targetBuildingId,
                        'engineer_id'           => $engineer->id,
                        'phase'                 => 'foundation',
                        'completion_percentage' => $cumulativePercentage,
                        'daily_progress'        => $day['progress'],
                        'status'                => $day['status'],
                        'manpower_count'        => $day['manpower'],
                        'issues_count'          => $day['days_back'] === 2 ? 1 : 0,
                        'report_date'           => $currentLoopDate->format('Y-m-d H:i:s'),
                        'recorded_at'           => $currentLoopDate->format('Y-m-d H:i:s'),
                        'description'           => "Report generated for manpower analysis testing by Eng. {$user->first_name}.",
                    ]);

                    // 🎯 3️⃣ تشغيل الـ Job التحليلي في آخر يوم حصراً لحساب النتائج كاملة لـ 7 أيام
                    if ($day['days_back'] === 0) {
                        AnalyzeLaborProductivityJob::dispatchSync($report);
                    }
                }
            }

            $this->command->info("✅ Generated & Analyzed 7-day reports for Eng: {$user->first_name} {$user->last_name}");
        }

        $this->command->info('🎉 SEEDER COMPLETED SUCCESSFULLY: Construction Insights (WARNING, DANGER, SUCCESS) Generated for Admin!');
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Engineer\Engineer;
use App\Models\Engineer\ProjectEngineerAllocation;
use App\Models\Engineer\Attendance;
use App\Models\RealEstate\Project;
use App\Models\RealEstate\Building;
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

        // 1️⃣ رفع الملفات الوهمية للـ Storage (مرة واحدة فقط)
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
            $this->command->error("❌ Failed to upload Image to Supabase: " . $e->getMessage());
        }

        // 2️⃣ جلب المشاريع الشغالة حصراً (In Progress) لتوزيع المهندسين عليها
        $activeProjects = Project::where('status', 'in_progress')->with(['buildings' => function ($q) {
            $q->where('status', 'in_progress');
        }])->get();

        if ($activeProjects->isEmpty()) {
            $this->command->error('❌ لا يوجد مشاريع بحالة in_progress! يرجى تشغيل الـ ProjectSeeder المطور أولاً.');
            return;
        }

        // 3️⃣ طاقم المهندسين الجديد (بيانات واقعية ومتنوعة)
        $engineersData = [
            [
                'user' => [
                    'first_name' => 'Tommy',
                    'last_name' => 'Shelby',
                    'email' => 'ts@eng.com',
                    'phone' => '+963911111111',
                    'address' => 'Damascus',
                    'gender' => 'male',
                    'type' => 'engineer',
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ],
                'profile' => ['specialization' => 'Civil Engineering', 'experience_years' => 8],
                'allocation_type' => 'project_wide' // 🎯 إسناد للمشروع كامل
            ],
            [
                'user' => [
                    'first_name' => 'Arthur',
                    'last_name' => 'Shelby',
                    'email' => 'as@eng.com',
                    'phone' => '+963922222222',
                    'address' => 'Aleppo',
                    'gender' => 'male',
                    'type' => 'engineer',
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ],
                'profile' => ['specialization' => 'Architectural Engineering', 'experience_years' => 5],
                'allocation_type' => 'specific_building' // 🎯 إسناد لبناء محدد
            ],
            [
                'user' => [
                    'first_name' => 'Ada',
                    'last_name' => 'Thorne',
                    'email' => 'at@eng.com',
                    'phone' => '+963933333333',
                    'address' => 'Homs',
                    'gender' => 'female',
                    'type' => 'engineer',
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ],
                'profile' => ['specialization' => 'Electrical Engineering', 'experience_years' => 4],
                'allocation_type' => 'multiple_buildings' // 🎯 إسناد لعدة أبنية داخل المشروع
            ]
        ];

        // مصفوفة سيناريو الـ 7 أيام التاريخية لضرب الإنتاجية
        $sevenDaysScenario = [
            ['days_back' => 6, 'manpower' => 12, 'progress' => 4.2, 'status' => 'on_track'],
            ['days_back' => 5, 'manpower' => 15, 'progress' => 4.5, 'status' => 'on_track'],
            ['days_back' => 4, 'manpower' => 14, 'progress' => 4.9, 'status' => 'on_track'],
            ['days_back' => 3, 'manpower' => 18, 'progress' => 4.0, 'status' => 'on_track'],
            ['days_back' => 2, 'manpower' => 35, 'progress' => 2.1, 'status' => 'on_track'], // تكدس عمال
            ['days_back' => 1, 'manpower' => 40, 'progress' => 1.3, 'status' => 'on_track'], // هبوط إنتاجية
            ['days_back' => 0, 'manpower' => 45, 'progress' => 0.8, 'status' => 'on_track'], // ذروة التكدس اليوم
        ];

        foreach ($engineersData as $index => $data) {
            $user = User::create($data['user']);
            $user->assignRole('engineer');

            $engineer = Engineer::create([
                'user_id' => $user->id,
                'specialization' => $data['profile']['specialization'],
                'experience_years' => $data['profile']['experience_years'],
            ]);

            // اختيار مشروع شغال بالتناوب لضمان توزيع المهندسين على المشاريع المتاحة
            $project = $activeProjects[$index % $activeProjects->count()];
            $projectBuildings = $project->buildings;

            $allocations = []; // مصفوفة لحفظ الأبنية المستهدفة لكل مهندس لغرض توليد التقارير

            // 4️⃣ هندسة الـ Allocations بناءً على نوع الإسناد المكتوب فوق
            if ($data['allocation_type'] === 'project_wide' || $projectBuildings->isEmpty()) {
                // إسناد على مستوى المشروع بالكامل (building_id = null)
                ProjectEngineerAllocation::create([
                    'engineer_id' => $engineer->id,
                    'project_id'  => $project->id,
                    'building_id' => null,
                    'start_date'  => Carbon::now()->subMonths(1)->format('Y-m-d'),
                    'end_date'    => Carbon::now()->addMonths(5)->format('Y-m-d'),
                ]);
                $allocations[] = null; // التقرير والحضور حيكون عالمشروع
            } elseif ($data['allocation_type'] === 'specific_building') {
                // إسناد لبناء واحد محدد (أول بناء شغال)
                $targetBuilding = $projectBuildings->first();
                ProjectEngineerAllocation::create([
                    'engineer_id' => $engineer->id,
                    'project_id'  => $project->id,
                    'building_id' => $targetBuilding->id,
                    'start_date'  => Carbon::now()->subMonths(1)->format('Y-m-d'),
                    'end_date'    => Carbon::now()->addMonths(5)->format('Y-m-d'),
                ]);
                $allocations[] = $targetBuilding->id;
            } elseif ($data['allocation_type'] === 'multiple_buildings') {
                // إسناد لـ مبنيين مختلفين بنفس المشروع
                foreach ($projectBuildings->take(2) as $building) {
                    ProjectEngineerAllocation::create([
                        'engineer_id' => $engineer->id,
                        'project_id'  => $project->id,
                        'building_id' => $building->id,
                        'start_date'  => Carbon::now()->subMonths(1)->format('Y-m-d'),
                        'end_date'    => Carbon::now()->addMonths(5)->format('Y-m-d'),
                    ]);
                    $allocations[] = $building->id;
                }
            }

            // =================================================================
            // 📊 توليد سيناريو الـ 7 أيام لكل إسناد متاح عند المهندس الحالي
            // =================================================================
            foreach ($allocations as $targetBuildingId) {
                $cumulativePercentage = 15.50; // نسبة البداية لكل بناء/مشروع

                foreach ($sevenDaysScenario as $day) {
                    $currentLoopDate = Carbon::now()->subDays($day['days_back']);
                    $cumulativePercentage += $day['progress'];

                    // تسجيل الحضور التاريخي المتوافق
                    Attendance::create([
                        'uuid' => (string) Str::uuid(),
                        'engineer_id' => $engineer->id,
                        'project_id' => $project->id,
                        'building_id' => $targetBuildingId,
                        'check_in_lat' => (string) ($project->latitude + 0.0001),
                        'check_in_lng' => (string) ($project->longitude + 0.0001),
                        'check_out_lat' => (string) ($project->latitude + 0.0001),
                        'device_id' => 'Device_' . Str::slug($user->first_name) . '_Test',
                        'checked_in_at' => $currentLoopDate->copy()->setTime(8, 0, 0)->format('Y-m-d H:i:s'),
                        'checked_out_at' => $currentLoopDate->copy()->setTime(16, 30, 0)->format('Y-m-d H:i:s'), // عمل خروج نظامي للماضي
                        'total_hours' => 8.5,
                    ]);

                    // بناء تقرير الإنجاز المتطابق جغرافياً وزمنياً
                    ConstructionReport::create([
                        'uuid'                  => (string) Str::uuid(),
                        'project_id'            => $project->id,
                        'building_id'           => $targetBuildingId,
                        'engineer_id'           => $engineer->id,
                        'phase'                 => 'foundation',
                        'completion_percentage' => $cumulativePercentage,
                        'daily_progress'        => $day['progress'],
                        'status'                => $day['status'],
                        'manpower_count'        => $day['manpower'],
                        'issues_count'          => $day['days_back'] === 2 ? 1 : 0, // محاكاة مشكلة بيوم التكدس
                        'report_date'           => $currentLoopDate->format('Y-m-d H:i:s'),
                        'recorded_at'           => $currentLoopDate->format('Y-m-d H:i:s'),
                        'description'           => "Generated report by Eng. {$user->first_name} for tracking manpower variance.",
                    ]);
                }
            }

            $this->command->info("✅ Seeded historical data for Engineer: {$user->first_name} {$user->last_name}");
        }

        $this->command->info('🎉 GRAND SUCCESS: All active engineers, cross-allocations, and historical timelines are synced perfectly!');
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Engineer\Engineer;
use App\Models\Engineer\EngineerProject;
use App\Models\Engineer\Attendance;
use App\Models\RealEstate\Project;
use App\Models\Engineer\ConstructionReport; // عدل مسار الموديل حسب مجلداتك
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class EngineerSystemSeeder extends Seeder
{
    public function run(): void
    {
        Storage::disk('public')->makeDirectory('reports');
        $dummyFilePath = 'reports/dummy_blueprint_report.pdf';

        if (!Storage::disk('public')->exists($dummyFilePath)) {
            Storage::disk('public')->put($dummyFilePath, '%PDF-1.5 ... Dummy Engineering Report Content ...');
        }

        $projects = Project::all();
        if ($projects->isEmpty()) {
            $this->command->warn('Please seed Projects first to link engineers properly!');
            return;
        }

        $engineersData = [
            [
                'user' => [
                    'first_name' => 'Ali',
                    'last_name' => 'Zaitoun',
                    'email' => 'ali.zaitoun@eng.com',
                    'phone' => '+963911111111',
                    'address' => 'Damascus, Syria',
                    'gender' => 'male',
                    'type' => 'engineer',
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ],
                'profile' => [
                    'specialization' => 'Software Engineer / IoT Systems',
                    'experience_years' => 4,
                ]
            ],
            [
                'user' => [
                    'first_name' => 'Ahmad',
                    'last_name' => 'Al-Saeed',
                    'email' => 'ahmad.saeed@eng.com',
                    'phone' => '+963922222222',
                    'address' => 'Mazzeh, Damascus',
                    'gender' => 'male',
                    'type' => 'engineer',
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ],
                'profile' => [
                    'specialization' => 'Civil Engineering / Site Manager',
                    'experience_years' => 7,
                ]
            ],
            [
                'user' => [
                    'first_name' => 'Rania',
                    'last_name' => 'Homsi',
                    'email' => 'rania.homsi@eng.com',
                    'phone' => '+963933333333',
                    'address' => 'Malki, Damascus',
                    'gender' => 'female',
                    'type' => 'engineer',
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ],
                'profile' => [
                    'specialization' => 'Architectural Design',
                    'experience_years' => 5,
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

            EngineerProject::create([
                'engineer_id' => $engineer->id,
                'project_id' => $project->id,
                'start_date' => Carbon::now()->subMonths(2)->format('Y-m-d'),
                'end_date' => Carbon::now()->addMonths(6)->format('Y-m-d'),
            ]);

            Attendance::create([
                'uuid' => (string) Str::uuid(),
                'engineer_id' => $engineer->id,
                'project_id' => $project->id,
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
                'building_id'           => null,
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
                'path'          => $dummyFilePath,
                'original_name' => 'site_blueprint_v1.pdf',
                'type'          => 'document',
                'recorded_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'custom_properties' => json_encode([
                    'file_size' => '1.2MB',
                    'uploaded_by' => 'System Seeder'
                ]),
            ]);
        }

        $this->command->info('Engineers, Project Allocations, Attendances, and Progress Reports with Dummy Files seeded successfully!');
    }
}

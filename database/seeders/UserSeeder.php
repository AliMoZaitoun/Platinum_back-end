<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserRole;
use App\Models\Client\Client;
use App\Models\Engineer\Engineer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'مدير النظام',
            'email' => 'admin@erp.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole(UserRole::ADMIN->value);

        User::factory(10)->create()->each(function ($user) {
            $user->assignRole(UserRole::CLIENT->value);
            Client::create(['user_id' => $user->id, 'national_id' => rand(1000000000, 9999999999)]);
        });

        // 3. إنشاء مهندسين
        User::factory(5)->create()->each(function ($user) {
            $user->assignRole(UserRole::ENGINEER->value);
            Engineer::create([
                'user_id' => $user->id,
                'specialization' => ['ar' => 'مهندس مدني', 'en' => 'Civil Engineer']
            ]);
        });

        User::factory(3)->create()->each(function ($user) {
            $user->assignRole(UserRole::FINANCE_STAFF->value);
        });
    }
}

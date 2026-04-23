<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            // Admin
            [
                'first_name'        => 'Omar',
                'last_name'         => 'Al-Rashidi',
                'email'             => 'omar.alrashidi@realestate.com',
                'phone'             => '+31 6 10000001',
                'address'           => 'Coolsingel 10, Rotterdam, South Holland',
                'gender'            => 'male',
                'role'              => 'admin',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
            ],

            // Sales & Leasing
            [
                'first_name'        => 'Sophie',
                'last_name'         => 'van der Berg',
                'email'             => 'sophie.vdberg@realestate.com',
                'phone'             => '+31 6 10000002',
                'address'           => 'Blaak 45, Rotterdam, South Holland',
                'gender'            => 'female',
                'role'              => 'employee',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'first_name'        => 'James',
                'last_name'         => 'Okafor',
                'email'             => 'james.okafor@realestate.com',
                'phone'             => '+31 6 10000003',
                'address'           => 'Nieuwe Binnenweg 78, Rotterdam, South Holland',
                'gender'            => 'male',
                'role'              => 'employee',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
            ],

            // Property Management
            [
                'first_name'        => 'Fatima',
                'last_name'         => 'El-Amin',
                'email'             => 'fatima.elamin@realestate.com',
                'phone'             => '+31 6 10000004',
                'address'           => 'Witte de Withstraat 22, Rotterdam, South Holland',
                'gender'            => 'female',
                'role'              => 'employee',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'first_name'        => 'Lars',
                'last_name'         => 'Hendriks',
                'email'             => 'lars.hendriks@realestate.com',
                'phone'             => '+31 6 10000005',
                'address'           => 'Schiedamse Vest 90, Rotterdam, South Holland',
                'gender'            => 'male',
                'role'              => 'employee',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
            ],

            // Marketing
            [
                'first_name'        => 'Nina',
                'last_name'         => 'Smits',
                'email'             => 'nina.smits@realestate.com',
                'phone'             => '+31 6 10000006',
                'address'           => 'Meent 12, Rotterdam, South Holland',
                'gender'            => 'female',
                'role'              => 'employee',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
            ],

            // Finance
            [
                'first_name'        => 'Pieter',
                'last_name'         => 'Visser',
                'email'             => 'pieter.visser@realestate.com',
                'phone'             => '+31 6 10000007',
                'address'           => 'Boompjes 50, Rotterdam, South Holland',
                'gender'            => 'male',
                'role'              => 'employee',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
            ],

            // Legal
            [
                'first_name'        => 'Amira',
                'last_name'         => 'Khalil',
                'email'             => 'amira.khalil@realestate.com',
                'phone'             => '+31 6 10000008',
                'address'           => 'Churchillplein 5, Rotterdam, South Holland',
                'gender'            => 'female',
                'role'              => 'employee',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
            ],

            // Construction
            [
                'first_name'        => 'Daan',
                'last_name'         => 'de Vries',
                'email'             => 'daan.devries@realestate.com',
                'phone'             => '+31 6 10000009',
                'address'           => 'Maashaven ZZ 1, Rotterdam, South Holland',
                'gender'            => 'male',
                'role'              => 'employee',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
            ],

            // IT
            [
                'first_name'        => 'Kevin',
                'last_name'         => 'Tran',
                'email'             => 'kevin.tran@realestate.com',
                'phone'             => '+31 6 10000010',
                'address'           => 'Lloydstraat 300, Rotterdam, South Holland',
                'gender'            => 'male',
                'role'              => 'employee',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use function Symfony\Component\Clock\now;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'first_name'        => 'Admin',
            'last_name'         => 'Admin',
            'email'             => 'admin@gmail.com',
            'phone'             => '9999999999',
            'address'           => 'Syria',
            'gender'            => 'male',
            'role'              => 'admin',
            'password'          => bcrypt("password"),
            'email_verified_at' => now()
        ]);

        $user->assignRole('admin');
    }
}

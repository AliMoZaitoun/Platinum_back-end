<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $clientUsers = [
            [
                'first_name'        => 'Youssef',
                'last_name'         => 'El-Mansouri',
                'email'             => 'youssef.elmansouri@gmail.com',
                'phone'             => '+31 6 20000001',
                'address'           => 'Bergweg 120, Rotterdam, South Holland',
                'gender'            => 'male',
                'role'              => 'client',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
                'client' => [
                    'birth_date'    => '1985-04-12',
                    'job_title'     => 'Civil Engineer',
                    'social_status' => 'married',
                    'national_id'   => 'NL198504120001',
                ],
            ],
            [
                'first_name'        => 'Lena',
                'last_name'         => 'Müller',
                'email'             => 'lena.muller@gmail.com',
                'phone'             => '+31 6 20000002',
                'address'           => 'Westersingel 55, Rotterdam, South Holland',
                'gender'            => 'female',
                'role'              => 'client',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
                'client' => [
                    'birth_date'    => '1990-08-25',
                    'job_title'     => 'Financial Consultant',
                    'social_status' => 'single',
                    'national_id'   => 'DE199008250002',
                ],
            ],
            [
                'first_name'        => 'Ahmed',
                'last_name'         => 'Al-Farsi',
                'email'             => 'ahmed.alfarsi@gmail.com',
                'phone'             => '+31 6 20000003',
                'address'           => 'Teilingerstraat 30, Rotterdam, South Holland',
                'gender'            => 'male',
                'role'              => 'client',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
                'client' => [
                    'birth_date'    => '1978-11-03',
                    'job_title'     => 'Business Owner',
                    'social_status' => 'married',
                    'national_id'   => 'AE197811030003',
                ],
            ],
            [
                'first_name'        => 'Isabelle',
                'last_name'         => 'Dupont',
                'email'             => 'isabelle.dupont@gmail.com',
                'phone'             => '+31 6 20000004',
                'address'           => 'Keizerstraat 14, Schiedam, South Holland',
                'gender'            => 'female',
                'role'              => 'client',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
                'client' => [
                    'birth_date'    => '1993-02-17',
                    'job_title'     => 'Architect',
                    'social_status' => 'single',
                    'national_id'   => 'FR199302170004',
                ],
            ],
            [
                'first_name'        => 'Khalid',
                'last_name'         => 'Al-Hamdan',
                'email'             => 'khalid.alhamdan@gmail.com',
                'phone'             => '+31 6 20000005',
                'address'           => 'Pijnackerstraat 8, Rotterdam, South Holland',
                'gender'            => 'male',
                'role'              => 'client',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
                'client' => [
                    'birth_date'    => '1970-06-30',
                    'job_title'     => 'Real Estate Investor',
                    'social_status' => 'married',
                    'national_id'   => 'SA197006300005',
                ],
            ],
            [
                'first_name'        => 'Emma',
                'last_name'         => 'de Jong',
                'email'             => 'emma.dejong@gmail.com',
                'phone'             => '+31 6 20000006',
                'address'           => 'Beukelsdijk 77, Rotterdam, South Holland',
                'gender'            => 'female',
                'role'              => 'client',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
                'client' => [
                    'birth_date'    => '1988-09-14',
                    'job_title'     => 'Doctor',
                    'social_status' => 'divorced',
                    'national_id'   => 'NL198809140006',
                ],
            ],
            [
                'first_name'        => 'Tariq',
                'last_name'         => 'Nasser',
                'email'             => 'tariq.nasser@gmail.com',
                'phone'             => '+31 6 20000007',
                'address'           => 'Aleidisstraat 3, Delft, South Holland',
                'gender'            => 'male',
                'role'              => 'client',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
                'client' => [
                    'birth_date'    => '1982-12-05',
                    'job_title'     => 'Software Engineer',
                    'social_status' => 'married',
                    'national_id'   => 'JO198212050007',
                ],
            ],
            [
                'first_name'        => 'Sara',
                'last_name'         => 'Bakker',
                'email'             => 'sara.bakker@gmail.com',
                'phone'             => '+31 6 20000008',
                'address'           => 'Zuiderpark 19, Rotterdam, South Holland',
                'gender'            => 'female',
                'role'              => 'client',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
                'client' => [
                    'birth_date'    => '1995-03-22',
                    'job_title'     => 'Marketing Manager',
                    'social_status' => 'single',
                    'national_id'   => 'NL199503220008',
                ],
            ],
        ];

        foreach ($clientUsers as $data) {
            $clientData = $data['client'];
            unset($data['client']);

            $user = User::create($data);

            $user->assignRole('client');

            Client::create([
                'user_id'       => $user->id,
                'birth_date'    => $clientData['birth_date'],
                'job_title'     => $clientData['job_title'],
                'social_status' => $clientData['social_status'],
                'national_id'   => $clientData['national_id'],
            ]);
        }
    }
}

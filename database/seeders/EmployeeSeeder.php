<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        // Create an employee record for every non-admin user
        $users = User::where('role', 'employee')->get();

        foreach ($users as $user) {
            $user->assignRole('employee');
            Employee::create([
                'user_id' => $user->id,
            ]);
        }
    }
}

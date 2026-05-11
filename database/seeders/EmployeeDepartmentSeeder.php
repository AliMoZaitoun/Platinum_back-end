<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Core\Department;
use App\Models\Core\Employee;
use App\Models\Core\EmployeeDepartment;
use App\Models\User;
use Illuminate\Database\Seeder;

class EmployeeDepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $assignments = [
            'sophie.vdberg@realestate.com'  => ['Finance & Accounting', 'manager', UserRole::FINANCE_STAFF],
            'pieter.visser@realestate.com'  => ['Finance & Accounting', 'staff', UserRole::FINANCE_STAFF],
            'james.okafor@realestate.com'   => ['Customer Service', 'staff', UserRole::CUSTOMER_SERVICE_STAFF],
            'fatima.elamin@realestate.com'  => ['Customer Service', 'supervisor', UserRole::CUSTOMER_SERVICE_STAFF],
            'lars.hendriks@realestate.com'  => ['Customer Service', 'staff', UserRole::CUSTOMER_SERVICE_STAFF],
            'nina.smits@realestate.com'     => ['Marketing & Communications', 'manager', UserRole::MARKETING_STAFF],
            'kevin.tran@realestate.com'     => ['Marketing & Communications', 'manager', UserRole::MARKETING_STAFF],
            'amira.khalil@realestate.com'   => ['Legal & Contracts', 'manager', UserRole::LEGAL_STAFF],
            'daan.devries@realestate.com'   => ['Legal & Contracts', 'staff', UserRole::LEGAL_STAFF],
        ];

        foreach ($assignments as $email => [$deptName, $position, $spatieRole]) {
            $user       = User::where('email', $email)->first();
            $employee   = Employee::where('user_id', $user->id)->first();
            $department = Department::where('name', $deptName)->first();

            if ($user && $employee && $department) {
                EmployeeDepartment::create([
                    'employee_id'   => $employee->id,
                    'department_id' => $department->id,
                    'position'      => $position,
                    'from_date'     => '2022-01-01',
                    'to_date'       => null,
                ]);

                $user->assignRole('employee');

                $user->assignRole($spatieRole->value);
            }
        }
    }
}

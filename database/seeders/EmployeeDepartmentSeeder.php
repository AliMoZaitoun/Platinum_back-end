<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Employee;
use App\Models\EmployeeDepartment;
use App\Models\User;
use Illuminate\Database\Seeder;

class EmployeeDepartmentSeeder extends Seeder
{
    public function run(): void
    {
        // Map email → [department name, position]
        $assignments = [
            'sophie.vdberg@realestate.com'  => ['Sales & Leasing',          'Senior Sales Agent'],
            'james.okafor@realestate.com'   => ['Sales & Leasing',          'Leasing Consultant'],
            'fatima.elamin@realestate.com'  => ['Property Management',      'Property Manager'],
            'lars.hendriks@realestate.com'  => ['Property Management',      'Facilities Coordinator'],
            'nina.smits@realestate.com'     => ['Marketing & Communications', 'Marketing Specialist'],
            'pieter.visser@realestate.com'  => ['Finance & Accounting',     'Financial Analyst'],
            'amira.khalil@realestate.com'   => ['Legal & Contracts',        'Legal Counsel'],
            'daan.devries@realestate.com'   => ['Construction & Renovation', 'Project Supervisor'],
            'kevin.tran@realestate.com'     => ['Information Technology',   'IT Administrator'],
        ];

        foreach ($assignments as $email => [$deptName, $position]) {
            $user       = User::where('email', $email)->first();
            $employee   = Employee::where('user_id', $user->id)->first();
            $department = Department::where('name', $deptName)->first();

            EmployeeDepartment::create([
                'employee_id'   => $employee->id,
                'department_id' => $department->id,
                'position'      => $position,
                'from_date'     => '2022-01-01',
                'to_date'       => null, // currently active
            ]);
        }
    }
}

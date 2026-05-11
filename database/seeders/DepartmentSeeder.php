<?php

namespace Database\Seeders;

use App\Models\Core\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            [
                'name'        => 'Customer Service',
                'description' => 'Oversees day-to-day operations of managed properties including tenant relations, maintenance coordination, and rent collection.',
            ],
            [
                'name'        => 'Marketing & Communications',
                'description' => 'Handles property listings, advertising campaigns, social media presence, open house coordination, and brand management.',
            ],
            [
                'name'        => 'Finance & Accounting',
                'description' => 'Manages financial reporting, invoicing, payroll, budgeting, and compliance with financial regulations.',
            ],
            [
                'name'        => 'Legal & Contracts',
                'description' => 'Drafts and reviews property contracts, lease agreements, title deeds, and ensures regulatory and legal compliance.',
            ]
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            [
                'name'        => 'Sales & Leasing',
                'description' => 'Responsible for property sales, leasing negotiations, client acquisition, and closing deals for residential and commercial properties.',
            ],
            [
                'name'        => 'Property Management',
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
            ],
            [
                'name'        => 'Construction & Renovation',
                'description' => 'Coordinates property refurbishments, new construction projects, contractor management, and site inspections.',
            ],
            [
                'name'        => 'Human Resources',
                'description' => 'Manages employee recruitment, onboarding, training, performance reviews, and company culture initiatives.',
            ],
            [
                'name'        => 'Information Technology',
                'description' => 'Maintains company systems, CRM platform, property listing portals, and internal IT infrastructure.',
            ],
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}

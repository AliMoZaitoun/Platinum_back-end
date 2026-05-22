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
                'name'        => [
                    'en' => 'Engineering & Project Management',
                    'ar' => 'الهندسة وإدارة المشاريع'
                ],
                'description' => [
                    'en' => 'Manages structural design, architectural planning, site supervision, project scheduling, and quality control for all construction projects.',
                    'ar' => 'إدارة التصميم الإنشائي، التخطيط المعماري، الإشراف الميداني، جدولة المشاريع، وضبط الجودة لجميع مشاريع البناء.'
                ],
            ],
            [
                'name'        => [
                    'en' => 'Customer Service',
                    'ar' => 'خدمة العملاء'
                ],
                'description' => [
                    'en' => 'Oversees day-to-day operations of managed properties including tenant relations, maintenance coordination, and rent collection.',
                    'ar' => 'الإشراف على العمليات اليومية للعقارات المدارة، بما في ذلك العلاقات مع المستأجرين، تنسيق الصيانة، وتحصيل الإيجارات.'
                ],
            ],
            [
                'name'        => [
                    'en' => 'Marketing & Communications',
                    'ar' => 'التسويق والاتصال'
                ],
                'description' => [
                    'en' => 'Handles property listings, advertising campaigns, social attachments presence, open house coordination, and brand management.',
                    'ar' => 'إدارة قوائم العقارات، الحملات الإعلانية، التواجد على منصات التواصل، تنسيق المعاينات المفتوحة، وإدارة الهوية التجارية.'
                ],
            ],
            [
                'name'        => [
                    'en' => 'Finance & Accounting',
                    'ar' => 'المالية والمحاسبة'
                ],
                'description' => [
                    'en' => 'Manages financial reporting, invoicing, payroll, budgeting, and compliance with financial regulations.',
                    'ar' => 'إدارة التقارير المالية، الفواتير، رواتب الموظفين، إعداد الموازنات، والامتثال للأنظمة واللوائح المالية.'
                ],
            ],
            [
                'name'        => [
                    'en' => 'Legal & Contracts',
                    'ar' => 'الشؤون القانونية والعقود'
                ],
                'description' => [
                    'en' => 'Drafts and reviews property contracts, lease agreements, title deeds, and ensures regulatory and legal compliance.',
                    'ar' => 'صياغة ومراجعة عقود العقارات، اتفاقيات الإيجار، صكوك الملكية، وضمان الامتثال القانوني والتشريعي.'
                ],
            ]
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }

        $this->command->info('🎉 Departments seeded successfully with translatable JSON fields!');
    }
}

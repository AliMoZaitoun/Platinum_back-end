<?php

namespace Database\Seeders;

use App\Models\RealEstate\Solution;
use Illuminate\Database\Seeder;

class SolutionSeeder extends Seeder
{
    public function run(): void
    {
        $solutions = [
            [
                'name' => [
                    'ar' => 'بيع العقارات السكنية',
                    'en' => 'Residential Property Sale'
                ],
                'description' => [
                    'ar' => 'خدمة وساطة متكاملة لشراء وبيع العقارات السكنية بما في ذلك الشقق والفيلات والتاون هاوس. تشمل تقييم السوق، الإدراج، الجولات، ودعم الإغلاق.',
                    'en' => 'Full-service brokerage for buying and selling residential properties including apartments, villas, and townhouses. Includes market valuation, listing, showings, and closing support.'
                ],
                'price' => 3500.00,
            ],
            [
                'name' => [
                    'ar' => 'بيع العقارات التجارية',
                    'en' => 'Commercial Property Sale'
                ],
                'description' => [
                    'ar' => 'دعم شامل للمعاملات العقارية التجارية بما في ذلك المساحات المكتبية، وحدات التجزئة، والعقارات الصناعية. يشمل الفحص النافي للجهالة والتفاوض.',
                    'en' => 'End-to-end support for commercial real estate transactions including office spaces, retail units, and industrial properties. Includes due diligence and negotiation.'
                ],
                'price' => 8500.00,
            ],
            [
                'name' => [
                    'ar' => 'إيجار سكني طويل الأجل',
                    'en' => 'Long-Term Residential Lease'
                ],
                'description' => [
                    'ar' => 'البحث عن المستأجرين، صياغة عقود الإيجار، التحقق من الخلفية، وتنسيق الانتقال للإيجارات السكنية طويلة الأجل (أكثر من 12 شهراً).',
                    'en' => 'Tenant sourcing, lease drafting, background checks, and move-in coordination for long-term residential rentals (12+ months).'
                ],
                'price' => 1200.00,
            ],
            [
                'name' => [
                    'ar' => 'إدارة الإيجارات قصيرة الأجل والعطلات',
                    'en' => 'Short-Term & Holiday Rental Management'
                ],
                'description' => [
                    'ar' => 'إدارة كاملة للإيجارات لقضاء العطلات قصيرة الأجل بما في ذلك الإدراج على المنصات، التواصل مع الضيوف، تنسيق التنظيف، والتقارير المالية.',
                    'en' => 'Full management of short-term holiday rentals including listing on platforms, guest communication, cleaning coordination, and financial reporting.'
                ],
                'price' => 950.00,
            ],
            [
                'name' => [
                    'ar' => 'تقييم وتثمين العقارات',
                    'en' => 'Property Valuation & Appraisal'
                ],
                'description' => [
                    'ar' => 'تقرير تقييم سوقي مهني للعقارات السكنية أو التجارية، يتضمن تحليلاً مقارناً للسوق وتقييم حالة العقار.',
                    'en' => 'Professional market valuation report for residential or commercial properties, including comparative market analysis and condition assessment.'
                ],
                'price' => 450.00,
            ],
            [
                'name' => [
                    'ar' => 'إدارة الأملاك والعقارات (شهري)',
                    'en' => 'Property Management (Monthly)'
                ],
                'description' => [
                    'ar' => 'إدارة شهرية مستمرة للعقارات المؤجرة تشمل تحصيل الإيجارات، تنسيق الصيانة، التواصل مع المستأجرين، والتقارير الشهرية للمالك.',
                    'en' => 'Ongoing monthly management of leased properties including rent collection, maintenance coordination, tenant communication, and monthly owner reporting.'
                ],
                'price' => 350.00,
            ],
            [
                'name' => [
                    'ar' => 'استشارات ترميم وتجديد العقارات',
                    'en' => 'Property Renovation Consultancy'
                ],
                'description' => [
                    'ar' => 'مشورة الخبراء وتنسيق المشاريع لترميم وتجديد العقارات لزيادة قيمتها السوقية. تشمل توفير المقاولين وإدارة الجدول الزمني.',
                    'en' => 'Expert advice and project coordination for property renovation and refurbishment to increase market value. Includes contractor sourcing and timeline management.'
                ],
                'price' => 2200.00,
            ],
            [
                'name' => [
                    'ar' => 'استشارات المحافظ الاستثمارية العقارية',
                    'en' => 'Investment Portfolio Advisory'
                ],
                'description' => [
                    'ar' => 'خدمة استشارية استراتيجية للمستثمرين العقاريين. تشمل تحليل السوق، توقعات العائد على الاستثمار (ROI)، تقييم المخاطر، وتخطيط تنويع المحفظة.',
                    'en' => 'Strategic advisory service for real estate investors. Includes market analysis, ROI projections, risk assessment, and portfolio diversification planning.'
                ],
                'price' => 5000.00,
            ],
            [
                'name' => [
                    'ar' => 'خدمات العقود القانونية والتوثيق',
                    'en' => 'Legal Contract & Documentation Service'
                ],
                'description' => [
                    'ar' => 'صياغة ومراجعة وتوثيق العقود العقارية، اتفاقيات الإيجار، ووثائق نقل الملكية بما يتوافق مع القوانين والأنظمة العقارية.',
                    'en' => 'Drafting, reviewing, and notarizing property contracts, lease agreements, and title transfer documents in compliance with real estate law.'
                ],
                'price' => 750.00,
            ],
            [
                'name' => [
                    'ar' => 'إنتاج جولات عقارية افتراضية',
                    'en' => 'Virtual Property Tour Production'
                ],
                'description' => [
                    'ar' => 'إنتاج جولات افتراضية ثلاثية الأبعاد (3D) عالية الجودة وتصوير جوي بطائرات الدرون لقوائم العقارات لجذب المشترين والمستأجرين عن بعد.',
                    'en' => 'Production of high-quality virtual 3D tours and aerial drone photography for property listings to attract remote buyers and tenants.'
                ],
                'price' => 600.00,
            ],
        ];

        foreach ($solutions as $solution) {
            Solution::create($solution);
        }
    }
}

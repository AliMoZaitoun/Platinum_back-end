<?php

namespace Database\Seeders;

use App\Models\Core\Warehouse;
use App\Models\RealEstate\Location;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    public function run(): void
    {
        $districts = Location::where('type', 'district')->get();

        if ($districts->isEmpty()) {
            $this->command->error('يرجى تشغيل LocationSeeder أولاً لتوفير المناطق!');
            return;
        }

        $warehouses = [
            [
                'name'        => [
                    'en' => 'Main Documents Archive',
                    'ar' => 'أرشيف الوثائق الرئيسي'
                ],
                'address'     => 'HQ Building, Floor B1 - Rotterdam, South Holland',
                'location_id' => $districts->first()->id,
                'description' => [
                    'en' => 'Secure, climate-controlled archive dedicated to storing original property deeds, blue prints, legal engineering contracts, and official project documentation.',
                    'ar' => 'أرشيف آمن ومحمي حرارياً مخصص لحفظ صكوك الملكية الأصلية، المخططات الهندسية، عقود المقاولات القانونية، والوثائق الرسمية للمشاريع.'
                ],
            ],
            [
                'name'        => [
                    'en' => 'Property Equipment Storage',
                    'ar' => 'مستودع المعدات والأدوات العقارية'
                ],
                'address'     => 'Industrial Zone, Unit 4A - Rotterdam, South Holland',
                'location_id' => $districts->first()->id,
                'description' => [
                    'en' => 'Central depot for real estate maintenance tools, site inspection gear, safety equipment, and machinery used by field engineers.',
                    'ar' => 'المستودع المركزي لأدوات الصيانة العقارية، ومعدات الفحص الموقعي، وأدوات السلامة، والآليات المستخدمة من قبل مهندسي الموقع.'
                ],
            ],
            [
                'name'        => [
                    'en' => 'Furniture & Staging Depot',
                    'ar' => 'مستودع الأثاث والتجهيز التسويقي'
                ],
                'address'     => 'Logistics Park, Bay 12 - Schiedam, South Holland',
                'location_id' => $districts->first()->id,
                'description' => [
                    'en' => 'Storage facility for interior design assets, staging furniture, and marketing materials used to prep luxury properties for open houses and client viewings.',
                    'ar' => 'مرفق تخزين لأصول التصميم الداخلي، وأثاث التجهيز، والمواد التسويقية المستخدمة لإعداد العقارات الفاخرة للعروض المفتوحة ومعاينات العملاء.'
                ],
            ],
            [
                'name'        => [
                    'en' => 'Construction Materials Store',
                    'ar' => 'مخزن مواد البناء والإنشاءات'
                ],
                'address'     => 'North Warehouse Complex, Block C - Delft, South Holland',
                'location_id' => $districts->last()->id,
                'description' => [
                    'en' => 'Heavy-duty warehouse containing raw building materials, structural components, electrical supplies, and plumbing fixtures for ongoing real estate development projects.',
                    'ar' => 'مستودع للمهمات الثقيلة يحتوي على مواد البناء الأولية، المكونات الهيكلية، التمديدات الكهربائية، والتجهيزات الصحية لمشاريع التطوير العقاري الجارية.'
                ],
            ],
            [
                'name'        => [
                    'en' => 'IT & Office Equipment Store',
                    'ar' => 'مخزن تكنولوجيا المعلومات والمعدات المكتبية'
                ],
                'address'     => 'HQ Building, Floor B2 - Rotterdam, South Holland',
                'location_id' => $districts->last()->id,
                'description' => [
                    'en' => 'Internal tech repository for company hardware, including site computers, networking devices, plotters, and replacement office workstations for engineering teams.',
                    'ar' => 'مستودع التقنية الداخلي للأجهزة الخاصة بالشركة، ويشمل حواسيب المواقع، أجهزة الشبكات، الطابعات الهندسية الكبيرة (Plotters)، ومحطات العمل المكتبية البديلة للفرق الهندسية.'
                ],
            ],
        ];

        foreach ($warehouses as $warehouse) {
            Warehouse::create($warehouse);
        }

        $this->command->info('🎉 Warehouses seeded successfully with translatable JSON fields!');
    }
}

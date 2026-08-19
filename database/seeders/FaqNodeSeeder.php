<?php

namespace Database\Seeders;

use App\Models\FaqNode;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class FaqNodeSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        FaqNode::truncate();
        Schema::enableForeignKeyConstraints();

        $salesCategory = FaqNode::create([
            'title'      => ['ar' => '💳 المبيعات والأقساط', 'en' => '💳 Sales & Installments'],
            'type'       => 'category',
            'sort_order' => 1,
        ]);

        FaqNode::create([
            'parent_id'  => $salesCategory->id,
            'title'      => ['ar' => 'كيف يمكنني دفع القسط القادم؟', 'en' => 'How can I pay my next installment?'],
            'type'       => 'answer',
            'content'    => ['ar' => 'يمكنك دفع القسط من خلال التحويل البنكي لحساب الشركة، أو الدفع النقدي في مقر المبيعات الرئيسي.', 'en' => 'You can pay via bank transfer to the company account, or in cash at the main sales office.'],
            'sort_order' => 1,
        ]);

        FaqNode::create([
            'parent_id'  => $salesCategory->id,
            'title'      => ['ar' => 'متى يتم نقل الملكية رسمياً؟', 'en' => 'When is ownership officially transferred?'],
            'type'       => 'answer',
            'content'    => ['ar' => 'يتم نقل الملكية وتغيير حالة الوحدة إلى "مباعة" تلقائياً فور سداد الدفعة الأخيرة من العقد.', 'en' => 'Ownership is transferred and the unit status automatically changes to "Sold" upon payment of the final installment.'],
            'sort_order' => 2,
        ]);

        FaqNode::create([
            'parent_id'  => $salesCategory->id,
            'title'      => ['ar' => 'ما هي غرامات التأخير؟', 'en' => 'What are the late payment penalty fees?'],
            'type'       => 'answer',
            'content'    => ['ar' => 'يتم احتساب غرامة تأخير بنسبة 2% من قيمة القسط عن كل شهر تأخير بعد انقضاء فترة السماح المحددة بـ 15 يوماً.', 'en' => 'A late fee of 2% of the installment amount is calculated for each month of delay after the 15-day grace period.'],
            'sort_order' => 3,
        ]);

        FaqNode::create([
            'parent_id'  => $salesCategory->id,
            'title'      => ['ar' => 'لم أجد إجابتي / التحدث لموظف المبيعات', 'en' => 'Didn\'t find my answer / Talk to a Sales Agent'],
            'type'       => 'action_human',
            'sort_order' => 4,
        ]);

        $maintenanceCategory = FaqNode::create([
            'title'      => ['ar' => '🛠️ الدعم الفني والصيانة', 'en' => '🛠️ Technical Support & Maintenance'],
            'type'       => 'category',
            'sort_order' => 2,
        ]);

        FaqNode::create([
            'parent_id'  => $maintenanceCategory->id,
            'title'      => ['ar' => 'ما هي أوقات عمل فريق الصيانة؟', 'en' => 'What are the maintenance team working hours?'],
            'type'       => 'answer',
            'content'    => ['ar' => 'يعمل فريق الصيانة يومياً من الساعة 8 صباحاً حتى 4 عصراً، عدا يوم الجمعة والعطل الرسمية.', 'en' => 'The maintenance team operates daily from 8 AM to 4 PM, except Fridays and public holidays.'],
            'sort_order' => 1,
        ]);

        $routineMaintenanceCategory = FaqNode::create([
            'parent_id'  => $maintenanceCategory->id,
            'title'      => ['ar' => 'طلب صيانة دورية', 'en' => 'Request Routine Maintenance'],
            'type'       => 'category',
            'sort_order' => 2,
        ]);

        FaqNode::create([
            'parent_id'  => $routineMaintenanceCategory->id,
            'title'      => ['ar' => 'صيانة التكييف', 'en' => 'AC Maintenance'],
            'type'       => 'answer',
            'content'    => ['ar' => 'صيانة التكييف الدورية تتم مرتين سنوياً مجاناً خلال فترة الضمان. يمكنك حجز موعد من خلال تطبيق إدارة الأملاك.', 'en' => 'Routine AC maintenance is done twice a year for free during the warranty period. You can book an appointment via the property management app.'],
            'sort_order' => 1,
        ]);

        FaqNode::create([
            'parent_id'  => $routineMaintenanceCategory->id,
            'title'      => ['ar' => 'أعطال السباكة والكهرباء', 'en' => 'Plumbing & Electrical Issues'],
            'type'       => 'action_human',
            'sort_order' => 2,
        ]);

        FaqNode::create([
            'parent_id'  => $maintenanceCategory->id,
            'title'      => ['ar' => 'الإبلاغ عن عطل طارئ (تحدث لموظف)', 'en' => 'Report an Emergency (Talk to Agent)'],
            'type'       => 'action_human',
            'sort_order' => 3,
        ]);

        $facilitiesCategory = FaqNode::create([
            'title'      => ['ar' => '🏢 إدارة المرافق (المسبح، المواقف، النادي)', 'en' => '🏢 Facility Management (Pool, Parking, Gym)'],
            'type'       => 'category',
            'sort_order' => 3,
        ]);

        FaqNode::create([
            'parent_id'  => $facilitiesCategory->id,
            'title'      => ['ar' => 'تخصيص مواقف السيارات', 'en' => 'Parking Allocation'],
            'type'       => 'answer',
            'content'    => ['ar' => 'يتم تخصيص موقف واحد لكل شقة بشكل مجاني. يمكن استئجار موقف إضافي بالتواصل مع الإدارة.', 'en' => 'One free parking spot is allocated per apartment. Additional spots can be rented by contacting management.'],
            'sort_order' => 1,
        ]);

        FaqNode::create([
            'title'      => ['ar' => '📞 شكاوى واقتراحات (تحدث لموظف الإدارة)', 'en' => '📞 Complaints & Suggestions (Talk to Management)'],
            'type'       => 'action_human',
            'sort_order' => 4,
        ]);
    }
}

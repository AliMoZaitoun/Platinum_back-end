<?php

return [
    'overdue_client_title' => '⚠️ تنبيه تأخير سداد',
    'overdue_client_body'  => 'نود تذكيركم بأن الدفعة المستحقة بتاريخ :date بقيمة :amount لم يتم سدادها بعد للعقد رقم #:contract.',

    'overdue_employee_title' => 'دفعة متأخرة لعميل',
    'overdue_employee_body'  => 'العميل :name لديه دفعة متأخرة للعقد رقم #:contract.',


    'payment_uploaded_title'   => 'وصل دفع جديد بانتظار المراجعة',
    'payment_uploaded_body'    => 'قام العميل :client برفع وصل دفع بقيمة :amount ويحتاج للمراجعة.',
    'payment_approved_title'   => 'تم قبول دفعتك بنجاح',
    'payment_approved_body'    => 'تم اعتماد دفعتك المالية بقيمة :amount وتحديث حسابك.',
    'payment_rejected_title'   => 'ملاحظة حول وصل الدفع',
    'payment_rejected_body'    => 'عذراً، تم رفض وصل الدفع بقيمة :amount، يرجى إعادة رفعه بصورة واضحة.',


    # Engineer
    'engineer_allocation_title' => '🏗️ مهمة هندسية جديدة',
    'engineer_allocation_building' => "تم إسنادك للإشراف الميداني على ':building' ضمن ':project'. تبدأ المهمة بتاريخ :date.",
    'engineer_allocation_project' => "تم إسنادك للإشراف الميداني على ':project' بالكامل. تبدأ المهمة بتاريخ :date.",


    # Complaint
    'complaint_status_title' => '🔄 تحديث حالة الشكوى',
    'complaint_status_body'  => "تم تحديث حالة الشكوى الخاصة بك ':title' لتصبح: :status.",

    'new_complaint_title'    => '🚨 شكوى جديدة مستلمة!',
    'new_complaint_body'     => "تم استلام شكوى جديدة بعنوان ':title'، يرجى المتابعة والرد.",

    'unknown_client'         => 'غير معروف',


    # Order
    'new_order_title'      => '🆕 طلب جديد مستلم!',
    'new_order_body'       => 'تم استلام طلب جديد رقم #:order_id من العميل، بانتظار المراجعة والموافقة الأولية.',

    'order_transfer_title' => 'طلب جديد محول',
    'order_transfer_body'  => 'تم تحويل الطلب رقم #:order_id إلى قسمكم.',

    'contract_created_title' => 'تم إنشاء عقد جديد',
    'contract_created_body'  => 'تم إنشاء عقد جديد بنجاح برقم المرجع :reference.',

    // Finance/Payment Notifications
    'payment_success_title'  => 'تم الدفع بنجاح',
    'payment_success_body'   => 'تم استلام دفعتك بقيمة :amount بنجاح. شكراً لك.',

    // Lottery Notifications
    'lottery_participation_title' => 'الدخول في السحب',
    'lottery_participation_body'  => 'تمت إضافتك بنجاح للسحب على الوحدة العقارية :unit. نتمنى لك التوفيق!',

    'lottery_winner_title' => 'تهانينا! لقد ربحت',
    'lottery_winner_body'  => 'أنت الفائز المحظوظ في سحب القرعة العقارية! سيتم التواصل معك قريباً لاستكمال الإجراءات.',

    'lottery_loser_title'  => 'نتائج القرعة العقارية',
    'lottery_loser_body'   => 'لم يحالفك الحظ في هذا السحب. نتمنى لك التوفيق في السحوبات القادمة!',
];

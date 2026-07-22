<?php

namespace App\Enums;

enum TransactionCategory: string
{
    case INSTALLMENT = 'installment';           // دفعات أقساط العقارات
    case DOWN_PAYMENT = 'down_payment';         // دفعة أولى / عربون
    case RENT = 'rent';                         // إيجارات

    case FINAL_PAYMENT = 'final_payment';                         // إيجارات
    case MAINTENANCE_FEES = 'maintenance_fees';                         // إيجارات


    case WAREHOUSE_PURCHASE = 'warehouse_purchase'; // مشتريات بضاعة للمستودع
    case SALARY = 'salary';                         // رواتب ومستحقات موظفين
    case PETTY_CASH = 'petty_cash';                 // مصاريف نثرية / تشغيلية
    case MAINTENANCE = 'maintenance';               // صيانة وإصلاحات
    case TAX = 'tax';                               // ضرائب ورسوم حكومية

    case OTHER = 'other';                           // أخرى


    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}

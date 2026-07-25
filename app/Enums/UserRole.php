<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case CLIENT = 'client';
    case EMPLOYEE = 'employee';
    case ENGINEER = 'engineer';

    case MARKETING_STAFF = 'marketing_staff';
    case LEGAL_STAFF = 'legal_staff';
    case FINANCE_STAFF = 'finance_staff';
    case CUSTOMER_SERVICE_STAFF = 'customer_service_staff';
    case ENGINEERING_STAFF = 'engineering_staff';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function fromDepartmentName(string|array $deptName): string
    {
        $name = is_array($deptName)
            ? strtolower($deptName['en'] ?? $deptName['ar'] ?? '')
            : strtolower($deptName);

        return match (true) {
            str_contains($name, 'engineering') || str_contains($name, 'مشاري') || str_contains($name, 'هندس')
            => self::ENGINEERING_STAFF->value,

            str_contains($name, 'customer') || str_contains($name, 'عملاء') || str_contains($name, 'خدم')
            => self::CUSTOMER_SERVICE_STAFF->value,

            str_contains($name, 'marketing') || str_contains($name, 'تسويق') || str_contains($name, 'اتصال')
            => self::MARKETING_STAFF->value,

            str_contains($name, 'finance') || str_contains($name, 'مالي') || str_contains($name, 'محاسب')
            => self::FINANCE_STAFF->value,

            str_contains($name, 'legal') || str_contains($name, 'قانون') || str_contains($name, 'عقود')
            => self::LEGAL_STAFF->value,

            default => self::EMPLOYEE->value,
        };
    }
}

<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case CLIENT = 'client';
    case EMPLOYEE = 'employee';
    case ENGINEER = 'engineer';

    case DEPT_MANAGER = 'dept_manager';

    case MARKETING_STAFF = 'marketing_staff';
    case LEGAL_STAFF = 'legal_staff';
    case FINANCE_STAFF = 'finance_staff';
    case CUSTOMER_SERVICE_STAFF = 'customer_service_staff';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function getRoleFromPosition(string $position): self
    {
        return match ($position) {
            'manager'    => self::DEPT_MANAGER,
            default      => self::DEPT_STAFF,
        };
    }
}

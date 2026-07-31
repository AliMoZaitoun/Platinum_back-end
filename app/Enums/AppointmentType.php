<?php

namespace App\Enums;

enum AppointmentType: string
{
    case SALES = 'sales';
    case LEGAL_CONSULTATION = 'legal_consultation';
    case GENERAL = 'general';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}

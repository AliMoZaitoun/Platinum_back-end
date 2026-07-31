<?php

namespace App\Enums\Reports;

enum InsightType: string
{
    case LABOR_OVERCROWDING = 'labor_overcrowding';
    case MATERIAL_WASTE = 'material_waste';
    case SCHEDULE_DELAY = 'schedule_delay';
    case STAGNATION_GAP = 'stagnation_gap';

    case AHEAD_OF_SCHEDULE = 'ahead_of_schedule';
    case HIGH_PRODUCTIVITY = 'high_productivity';
    case BUDGET_SAVING = 'budget_saving';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}

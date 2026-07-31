<?php

namespace App\Enums\Reports;

enum InsightSeverity: string
{
    case SUCCESS = 'success';
    case INFO    = 'info';
    case WARNING = 'warning';
    case DANGER  = 'danger';
}

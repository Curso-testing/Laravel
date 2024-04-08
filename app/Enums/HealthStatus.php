<?php

namespace App\Enums;

enum HealthStatus: string
{
    case HEALTHY = 'HEALTHY';
    case SICK = 'SICK';
    case HUNGRY = 'HUNGRY';
}

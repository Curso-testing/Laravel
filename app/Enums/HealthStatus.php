<?php

namespace App\Enums;

enum HealthStatus: string
{
    case HEALTHY = 'HEALTHY';
    case SICK = 'SICK';
    case HUNGRY = 'HUNGRY';

    public static function getValues(): array
    {
        return [
            self::HEALTHY,
            self::SICK,
            self::HUNGRY,
        ];
    }
}

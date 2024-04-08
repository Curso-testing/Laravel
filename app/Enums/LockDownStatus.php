<?php

namespace App\Enums;

enum LockDownStatus: string
{
    case ACTIVE = 'ACTIVE';
    case ENDED = 'ENDED';
    case RUN_FOR_YOUR_LIFE = 'RUN_FOR_YOUR_LIFE';
}

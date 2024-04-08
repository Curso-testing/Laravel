<?php

namespace App\Repositories;

use App\Models\LockDown;
use App\Enums\LockDownStatus;

class LockDownRepository
{
    public function findMostRecent(): ?LockDown
    {
        return LockDown::orderBy('created_at', 'desc')
            ->first();
    }

    public function isInLockDown(): bool
    {
        $lockDown = $this->findMostRecent();

        if (!$lockDown) {
            return false;
        }

        return $lockDown->status !== LockDownStatus::ENDED;
    }
}

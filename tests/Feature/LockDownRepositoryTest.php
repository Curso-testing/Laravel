<?php

namespace Tests\Feature;

use App\Enums\LockDownStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\LockDown;
use Carbon\Carbon;
use Illuminate\Cache\Lock;

class LockDownRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function testIsInLockDownReturnsFalseWithNoRows()
    {
        $this->assertFalse(LockDown::isInLockDown());
    }

    public function testIsInLockDownReturnsTrueIfMostRecentLockDownIsActive()
    {
        LockDown::create([
            'created_at' => Carbon::now()->subDay(),
            'status' => LockDownStatus::ACTIVE,
        ]);
        LockDown::factory()->count(5)->create([
            'created_at' => Carbon::now()->subDays(2),
            'status' => LockDownStatus::ENDED,
        ]);

        $this->assertTrue(LockDown::isInLockDown());
    }

    public function testIsInLockDownReturnsFalseIfMostRecentIsNotActive()
    {
        LockDown::create([
            'created_at' => Carbon::now()->subDay(),
            'status' => 'ENDED',
        ]);
        LockDown::factory()->count(5)->create([
            'created_at' => Carbon::now()->subDays(2),
            'status' => 'ACTIVE',
        ]);

        $this->assertFalse(LockDown::isInLockDown());
    }
}

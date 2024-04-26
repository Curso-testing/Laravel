<?php

use App\Enums\LockDownStatus;
use App\Models\LockDown;
use Carbon\Carbon;
use Illuminate\Cache\Lock;


uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('is in lock down returns false with no rows', function () {
    expect(LockDown::isInLockDown())->toBeFalse();
});

test('is in lock down returns true if most recent lock down is active', function () {
    LockDown::create([
        'created_at' => Carbon::now()->subDay(),
        'status' => LockDownStatus::ACTIVE,
    ]);
    LockDown::factory()->count(5)->create([
        'created_at' => Carbon::now()->subDays(2),
        'status' => LockDownStatus::ENDED,
    ]);

    expect(LockDown::isInLockDown())->toBeTrue();
});

test('is in lock down returns false if most recent is not active', function () {
    LockDown::create([
        'created_at' => Carbon::now()->subDay(),
        'status' => 'ENDED',
    ]);
    LockDown::factory()->count(5)->create([
        'created_at' => Carbon::now()->subDays(2),
        'status' => 'ACTIVE',
    ]);

    expect(LockDown::isInLockDown())->toBeFalse();
});
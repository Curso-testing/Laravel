<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\LockDown;
use App\Services\GithubService;
use App\Services\LockDownHelper;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Event;
use App\Notifications\LockDownLiftedNotification;

class LockDownHelperTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Simula tus notificaciones y eventos si es necesario
        Notification::fake();
        Event::fake();

        // Simula GithubService si es necesario
        $this->mock(GithubService::class, function ($mock) {
            $mock->shouldReceive('clearLockDownAlerts')->once();
        });
    }

    public function testEndCurrentLockdown()
    {
        $lockDown = LockDown::create([
            'status' => 'ACTIVE',
        ]);

        app(LockDownHelper::class)->endCurrentLockDown();

        $this->assertEquals('ENDED', $lockDown->fresh()->status);
    }

    public function testDinoEscapedPersistsLockDown()
    {
        app(LockDownHelper::class)->dinoEscaped();

        $this->assertDatabaseCount('lock_downs', 1);

        // Asumiendo que se dispara una notificación o evento cuando un dinosaurio escapa
        Notification::assertSentTo([$lockDown], LockDownLiftedNotification::class);

        // O si estás utilizando eventos
        // Event::assertDispatched(DinoEscaped::class);
    }
}

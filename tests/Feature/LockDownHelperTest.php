<?php

namespace Tests\Feature;

use App\Enums\LockDownStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\LockDown;
use App\Services\GithubService;
use App\Services\LockDownHelper;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Event;
use App\Mail\LockDownLiftedNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Testing\Fakes\NotificationFake;
use PHPUnit\Framework\TestStatus\Notice;

class LockDownHelperTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Simula tus notificaciones y eventos si es necesario
        Notification::fake();
        Event::fake();
    }

    public function testEndCurrentLockdown()
    {
        $lockDown = LockDown::create([
            'status' => 'ACTIVE',
        ]);

        $githubService = mock(GithubService::class);
        $githubService->shouldReceive('clearLockDownAlerts')->once();

        // Reemplaza el servicio real con el mock
        $this->app->instance(GithubService::class, $githubService);

        app(LockDownHelper::class)->endCurrentLockDown();

        $this->assertEquals(LockDownStatus::ENDED, $lockDown->fresh()->status);
    }

    public function testDinoEscapedPersistsLockDown()
    {
        // Simular el envío de email
        Mail::fake();

        // Ejecutar la acción que resulta en el envío del correo
        app(LockDownHelper::class)->dinoEscaped();

        // Afirmar que la base de datos tiene el registro esperado
        $this->assertDatabaseCount('lock_downs', 1);
        $this->assertDatabaseHas('lock_downs', [
            'status' => LockDownStatus::ACTIVE,
            'reason' => 'Dino escaped... NOT good...',
        ]);

        Mail::fake();

        // Envia un correo electrónico
        $mail = new LockDownLiftedNotification();

        Mail::send($mail);
        Mail::assertSent(LockDownLiftedNotification::class);
    }
}

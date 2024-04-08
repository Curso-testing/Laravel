<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\GithubService;
use App\Enums\HealthStatus;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class GithubServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Simula el Logger si es necesario
        Log::spy();

        // Preparar el entorno de prueba, como limpiar la caché
        Cache::flush();
    }

    /**
     * @dataProvider dinoNameProvider
     */
    public function testGetHealthReportReturnsCorrectHealthStatusForDino($expectedStatus, $dinoName)
    {
        Http::fake([
            'https://api.github.com/repos/SymfonyCasts/dino-park/issues' => Http::response([
                ['title' => 'Daisy', 'labels' => [['name' => 'Status: Sick']]],
                ['title' => 'Maverick', 'labels' => [['name' => 'Status: Healthy']]],
            ], 200),
        ]);

        $service = new GithubService();

        $this->assertSame($expectedStatus, $service->getHealthReport($dinoName)->value);

        // Asegúrate de que se llamó a la URL esperada
        Http::assertSent(function ($request) {
            return $request->url() == 'https://api.github.com/repos/SymfonyCasts/dino-park/issues';
        });
    }

    public function dinoNameProvider()
    {
        return [
            'Sick Dino' => [HealthStatus::SICK, 'Daisy'],
            'Healthy Dino' => [HealthStatus::HEALTHY, 'Maverick'],
        ];
    }

    public function testExceptionThrownWithUnknownLabel()
    {
        Http::fake([
            'https://api.github.com/repos/SymfonyCasts/dino-park/issues' => Http::response([
                ['title' => 'Maverick', 'labels' => [['name' => 'Status: Drowsy']]],
            ], 200),
        ]);

        $service = new GithubService();

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Drowsy is an unknown status label!');

        $service->getHealthReport('Maverick');
    }
}

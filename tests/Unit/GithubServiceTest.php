<?php

use App\Services\GithubService;
use App\Enums\HealthStatus;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;


beforeEach(function () {
    // Simula el Logger si es necesario
    Log::spy();

    // Preparar el entorno de prueba, como limpiar la caché
    Cache::flush();
});

test('get health report returns correct health status for dino', function ($expectedStatus, $dinoName) {
    Http::fake([
        'https://api.github.com/repos/SymfonyCasts/dino-park/issues' => Http::response([
            ['title' => 'Daisy', 'labels' => [['name' => 'Status: Sick']]],
            ['title' => 'Maverick', 'labels' => [['name' => 'Status: Healthy']]],
        ], 200),
    ]);

    $service = new GithubService();

    expect($service->getHealthReport($dinoName)->value)->toBe($expectedStatus);

    // Asegúrate de que se llamó a la URL esperada
    Http::assertSent(function ($request) {
        return $request->url() == 'https://api.github.com/repos/SymfonyCasts/dino-park/issues';
    });
})->with('dinoNameProvider');

dataset('dinoNameProvider', function () {
    return [
        'Sick Dino' => [HealthStatus::SICK->value, 'Daisy'],
        'Healthy Dino' => [HealthStatus::HEALTHY->value, 'Maverick'],
    ];
});

test('exception thrown with unknown label', function () {
    Http::fake([
        'https://api.github.com/repos/SymfonyCasts/dino-park/issues' => Http::response([
            ['title' => 'Maverick', 'labels' => [['name' => 'Status: Drowsy']]],
        ], 200),
    ]);

    $service = new GithubService();

    $this->expectException(\RuntimeException::class);
    $this->expectExceptionMessage('Drowsy is an unknown status label!');

    $service->getHealthReport('Maverick');
});

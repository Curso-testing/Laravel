<?php

namespace App\Services;

use App\Enums\HealthStatus;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class GithubService
{
    public function getHealthReport(string $dinosaurName): HealthStatus
    {
        $health = HealthStatus::HEALTHY;

        $data = Cache::remember('dino_issues', 60, function () use ($dinosaurName) {
            $response = Http::get('https://api.github.com/repos/SymfonyCasts/dino-park/issues');

            Log::info('Request Dino Issues', [
                'dino' => $dinosaurName,
                'responseStatus' => $response->status(),
            ]);

            return $response->json();
        });

        foreach ($data as $issue) {
            if (str_contains($issue['title'], $dinosaurName)) {
                $health = $this->getDinoStatusFromLabels($issue['labels']);
                break; // Suponiendo que solo necesitas el estado de salud del primer problema que coincida
            }
        }

        return $health;
    }

    public function clearLockDownAlerts(): void
    {
        Log::info('Cleaning lock down alerts on GitHub...');
        // Simula una llamada API a GitHub para limpiar las alertas
    }

    private function getDinoStatusFromLabels(array $labels): HealthStatus
    {
        $health = null;

        foreach ($labels as $label) {
            $labelName = $label['name'];

            if (!str_starts_with($labelName, 'Status:')) {
                continue;
            }

            $status = strtoupper(trim(substr($labelName, strlen('Status:'))));

            $health = HealthStatus::tryFrom($status);

            if (null === $health) {
                throw new \RuntimeException(sprintf('%s is an unknown status label!', $labelName));
            }

            break; // Suponiendo que solo necesitas evaluar un estado de salud por issue
        }

        return $health ?? HealthStatus::HEALTHY;
    }
}

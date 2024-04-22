<?php

namespace App\Services;

use App\Models\LockDown;
use App\Enums\LockDownStatus;
use Illuminate\Support\Facades\Mail;
use App\Mail\LockDownLiftedMail; // Suponiendo que tienes una clase Mailable para esto
use App\Jobs\ProcessLockDownLiftedNotification; // Suponiendo que implementaste un Job para manejar notificaciones
use App\Repositories\LockDownRepository; // Asume que has creado un repositorio de Laravel

class LockDownHelper
{
    private $lockDownRepository;
    private $githubService;

    public function __construct(LockDownRepository $lockDownRepository, GithubService $githubService)
    {
        $this->lockDownRepository = $lockDownRepository;
        $this->githubService = $githubService;
    }

    public function endCurrentLockDown(): void
    {
        $lockDown = $this->lockDownRepository->findMostRecent();
        if (!$lockDown) {
            throw new \LogicException('There is no lock down to end');
        }

        $lockDown->status = LockDownStatus::ENDED;
        $lockDown->save();

        $this->githubService->clearLockDownAlerts();
    }

    public function dinoEscaped(): void
    {
        $lockDown = new LockDown([
            'status' => LockDownStatus::ACTIVE,
            'reason' => 'Dino escaped... NOT good...',
        ]);
        $lockDown->save();

        // Aquí se despacha un job o se envía una notificación directamente
        //ProcessLockDownLiftedNotification::dispatch();

        // O enviar un correo directamente si prefieres
        // Mail::to($someAddress)->send(new LockDownLiftedMail());
    }
}

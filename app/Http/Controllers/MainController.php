<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dinosaur; // Asumiendo que has migrado las entidades a modelos de Eloquent
use App\Repositories\DinosaurRepository; // Necesitarás crear adaptaciones de los repositorios de Symfony a clases en Laravel que puedan usar Eloquent.
use App\Repositories\LockDownRepository;
use App\Services\GithubService;
use App\Services\LockDownHelper;

class MainController extends Controller
{
    private $github;
    private $dinosaurRepository;
    private $lockDownRepository;

    public function __construct(GithubService $github, DinosaurRepository $dinosaurRepository, LockDownRepository $lockDownRepository)
    {
        $this->github = $github;
        $this->dinosaurRepository = $dinosaurRepository;
        $this->lockDownRepository = $lockDownRepository;
    }

    public function index()
    {
        $dinos = $this->dinosaurRepository->findAll();

        foreach ($dinos as $dino) {
            $dino->health = $this->github->getHealthReport($dino->name);
        }

        return view('main.index', [
            'dinos' => $dinos,
            'isLockedDown' => $this->lockDownRepository->isInLockDown(),
        ]);
    }

    public function endLockDown(Request $request, LockDownHelper $lockDownHelper)
    {
        if (!$request->session()->token() == $request->_token) {
            abort(403, 'Invalid CSRF token');
        }

        $lockDownHelper->endCurrentLockDown();

        return redirect()->route('app_homepage');
    }
}

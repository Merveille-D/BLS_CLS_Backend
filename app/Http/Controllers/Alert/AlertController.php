<?php

namespace App\Http\Controllers\Alert;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use App\Repositories\Alert\AlertRepository;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class AlertController extends Controller
{
    public function __construct(private AlertRepository $alert) {

    }

    public function triggerModuleAlert() {

        $response = $this->alert->triggerModuleAlert();
        Http::get(env('APP_URL'). '/api/start-queue-worker');

        return api_response( $response, "Resultat de l'envoi des alertes", null, 200);
    }

    public function startQueueWorker(Request $request)
    {
        $process = new Process(['php', 'artisan', 'queue:work']);
        $process->start();

        return api_response( true, "Lancement de la file d'attente ", null, 200);
    }

}

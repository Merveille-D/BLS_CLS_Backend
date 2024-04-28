<?php

namespace App\Http\Controllers\Alert;

use App\Http\Controllers\Controller;
use App\Models\Alert\Alert;
use App\Repositories\Alert\AlertRepository;
use Illuminate\Validation\ValidationException;

class AlertController extends Controller
{
    public function __construct(private AlertRepository $alert) {

    }

    public function triggerModuleAlert() {

        $response = $this->alert->triggerModuleAlert();
        return api_response( $response, "Resultat de l'envoi des alertes", null, 200);
    }



}

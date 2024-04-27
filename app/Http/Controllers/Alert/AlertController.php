<?php

namespace App\Http\Controllers\Alert;

use App\Http\Controllers\Controller;
use App\Models\Alert\Alert;
use Illuminate\Http\Request;

class AlertController extends Controller
{
    public function index () {
        $alerts = Alert::when(request('type') !== null, function($query) {
            $query->where('type', request('type'));
        })->get()->map(function ($alert) {
            $alert->task = $alert->alertable->alert_form;
            return $alert;
        });

        return api_response(true, "Liste des alertes", $alerts, 200);
    }

    public function show() {
        $alert = Alert::find(request('id'));

        if (!$alert) {
            return api_response(false, "Alerte non trouvée", null, 404);
        }

        $alert->task = $alert->alertable->alert_form;

        return api_response(true, "Alerte trouvée", $alert, 200);
    }
}

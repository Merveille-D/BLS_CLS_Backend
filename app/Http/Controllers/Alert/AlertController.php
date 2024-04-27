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
}

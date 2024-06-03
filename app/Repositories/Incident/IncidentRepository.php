<?php
namespace App\Repositories\Incident;

use App\Concerns\Traits\PDF\GeneratePdfTrait;
use App\Models\Incident\Incident;
use App\Models\Incident\TaskIncident;
use Illuminate\Support\Facades\Auth;

class IncidentRepository
{
    use GeneratePdfTrait;

    public function __construct(private Incident $incident) {

    }

    /**
     * @param Request $request
     *
     * @return Incident
     */
    public function store($request) {

        $request['created_by'] = Auth::user()->id;
        $request['incident_reference'] = $request['type'] . '-' . now()->format('d') . '/' . now()->format('m') . '/' . now()->format('Y');
        $request['reference'] = generateReference('ICD - '. $request['type'], $this->incident);

        $incident = $this->incident->create($request);

        $this->createTasks($incident);
        return $incident;
    }

     /**
     * @param Request $request
     *
     * @return Incident
     */
    public function update(Incident $incident, $request) {

        $incident->update($request);
        return $incident;
    }

    private function createTasks($incident) {

        $type = $incident->type;
        $client = $incident->client;

        $tasks = TaskIncident::TASKS[$type][$client];

        $previousDeadline = null;

        foreach ($tasks as $key => $task) {
            $deadline = $previousDeadline ? $previousDeadline->addDays($task['delay']) : $incident->created_at->addDays($task['delay']);

            TaskIncident::create([
                'title' => $task['title'],
                'code' => $key,
                'incident_id' => $incident->id,
                'deadline' => $deadline,
                'created_by' => Auth::user()->id,
            ]);

            $previousDeadline = $deadline;
        }

        return true;
    }

    public function generatePdf($request){

        $incident = Incident::find($request['incident_id']);

        $data = $incident->toArray();
        $data['creator'] = $incident->creator;
        $data['author'] = $incident->authorIncident;
        $data['tasks'] = $incident->taskIncident;

        $pdf =  $this->generateFromView( 'pdf.incident.fiche_de_suivi',  [
            'data' => $data,
            'details' => $this->getDetails($data)
        ],$incident->title);

        return $pdf;
    }

    public function getDetails($data) {
        $details = [
            'N° de dossier' => $data['incident_reference'],
            'Statut actuel' => ($data['status'] == 0) ? "En cours" : "Terminé",
            'Intitulé' => $data['title'],
            'Date de réception' => $data['date_received'],
            'Type' => Incident::TYPE_VALUES[$data['type']],
            'Auteur' => $data['author']['name'],
            'Client de la banque' => $data['client'] ? "Oui" : "Non",
            'Créé par' => $data['creator']['firstname'] . '' . $data['creator']['lastname'],
        ];

        return $details;
    }

}

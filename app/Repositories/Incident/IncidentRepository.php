<?php

namespace App\Repositories\Incident;

use App\Concerns\Traits\PDF\GeneratePdfTrait;
use App\Models\Incident\Incident;
use App\Models\Incident\IncidentDocument;
use App\Models\Incident\TaskIncident;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class IncidentRepository
{
    use GeneratePdfTrait;

    public function __construct(private Incident $incident) {}

    /**
     * @param  Request  $request
     * @return Incident
     */
    public function store($request)
    {

        $request['created_by'] = Auth::user()->id;
        $request['incident_reference'] = $request['type'] . '-' . now()->format('d') . '/' . now()->format('m') . '/' . now()->format('Y');
        $request['reference'] = 'ICD -' . Incident::TYPE_CODES[$request['type']] . '-' . now()->format('d') . '/' . now()->format('m') . '/' . now()->format('Y');

        $incident = $this->incident->create($request);

        if (isset($request['incident_documents'])) {
            foreach ($request['incident_documents'] as $item) {

                $fileUpload = new IncidentDocument;

                $fileUpload->name = $item['name'];
                $fileUpload->file = uploadFile($item['file'], 'incident_documents');

                $incident->fileUploads()->save($fileUpload);
            }
        }

        $this->createTasks($incident);

        return $incident;
    }

    /**
     * @param  Request  $request
     * @return Incident
     */
    public function update(Incident $incident, $request)
    {

        $incident->update($request);

        return $incident;
    }

    public function generatePdf($request)
    {

        $incident = Incident::find($request['incident_id']);

        $data = $incident->toArray();
        $data['creator'] = $incident->creator;
        $data['author'] = $incident->authorIncident;
        $data['tasks'] = $incident->taskIncident;

        $filename = Str::slug($incident->title) . '_' . date('YmdHis') . '.pdf';

        $pdf = $this->generateFromView('pdf.incident.fiche_de_suivi', [
            'data' => $data,
            'details' => $this->getDetails($data),
        ], $filename);

        return $pdf;
    }

    public function getDetails($data)
    {
        $details = [
            'N° de dossier' => $data['incident_reference'],
            'Statut actuel' => ($data['status'] == 0) ? 'En cours' : 'Terminé',
            'Intitulé' => $data['title'],
            'Date de réception' => $data['date_received'],
            'Type' => __(Incident::TYPE_VALUES[$data['type']]),
            'Auteur' => $data['author']['name'],
            'Client de la banque' => $data['client'] ? 'Oui' : 'Non',
            'Créé par' => $data['creator']['firstname'] . '' . $data['creator']['lastname'],
        ];

        return $details;
    }

    private function createTasks($incident)
    {

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
}

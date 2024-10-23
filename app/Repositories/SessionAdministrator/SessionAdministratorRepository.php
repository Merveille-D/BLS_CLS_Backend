<?php
namespace App\Repositories\SessionAdministrator;

use App\Concerns\Traits\PDF\GeneratePdfTrait;
use App\Models\Gourvernance\BoardDirectors\Sessions\SessionAdministrator;
use App\Models\Gourvernance\BoardDirectors\Sessions\TaskSessionAdministrator;
use App\Models\Gourvernance\GourvernanceDocument;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SessionAdministratorRepository
{
    use GeneratePdfTrait;

    public function __construct(private SessionAdministrator $session) {

    }

    /**
     * @param Request $request
     *
     * @return SessionAdministrator
     */
    public function store($request) {

        $date = new DateTime(now());
        $reference = 'CA-' . '-' . $date->format('d') . '/' . $date->format('m') . '/' . $date->format('Y');
        $request['session_reference'] = $reference;

        $request['reference'] = generateReference('AG', $this->session);
        $request['created_by'] = Auth::user()->id;

        $session_administrator = $this->session->create($request->all());

        $this->createTasks($session_administrator);

        return $session_administrator;
    }

    /**
     * @param Request $request
     *
     * @return session_administrator
     */
    public function update(SessionAdministrator $session_administrator, $request) {

        $current_date = new DateTime($request["session_date"]);
        $old_date = new DateTime($session_administrator->session_date);

        $date_diff = $current_date->diff($old_date);

        $session_administrator->update($request);

        if($date_diff->format('%R%a') != 0) {
            $this->createTasks($session_administrator);
        }

        return $session_administrator;
    }

    /**
     * @param Request $request
     *
     * @return SessionAdministrator
     */
    public function attachement($request) {

        $session_administrator = SessionAdministrator::find($request->session_administrator_id);

        $files = $request['files'];

        foreach($files as $item) {

            $fieldName = SessionAdministrator::TYPE_FILE_FIELD_VALUE[$item['type']];

            $sessionAdministrator = new SessionAdministrator();
            if ($sessionAdministrator->isFillable($fieldName)) {

                $session_administrator->update([
                    $fieldName => uploadFile( $item['file'], 'ca_documents'),
                    SessionAdministrator::DATE_FILE_FIELD[$fieldName] => now(),
                ]);
            }else {

                $fileUpload = new GourvernanceDocument();

                $fileUpload->name = getFileName($item['file']);
                $fileUpload->file = uploadFile($item['file'], 'ca_documents');
                $fileUpload->status = $session_administrator->status;

                $session_administrator->fileUploads()->save($fileUpload);
            }
        }

        return $session_administrator;
    }

    public function createTasks($session_administrator) {

        if($session_administrator->tasks()->count() > 0) {
            $session_administrator->tasks()->delete();
        }

        $known_tasks = TaskSessionAdministrator::TASKS;
        foreach($known_tasks as $type => $tasks) {
            foreach($tasks as $task) {
                $task['type'] = $type;
                $task['session_administrator_id'] = $session_administrator->id;
                $task['created_by'] = Auth::user()->id;

                if($type == "pre_ca") {
                    $session_date = new DateTime($session_administrator->session_date);
                    $sign = $task['days'] >= 0 ? 1 : -1;
                    $deadline = $session_date->modify($sign * abs($task['days']) . ' days');
                    $task['deadline'] = $deadline;
                }
                $new_task = TaskSessionAdministrator::create($task);
            }
        }

        return $session_administrator;
    }

    public function checkStatus() {

        $session_administrators = SessionAdministrator::where('session_date', '<', now())->get();
        foreach($session_administrators as $session_administrator) {
            $session_administrator->update(['status' => 'post_ca']);
        }

        return 0;
    }

    public function generatePdf($request){

        $session_administrator = SessionAdministrator::find($request['session_administrator_id']);

        $meeting_type = __(SessionAdministrator::SESSION_MEETING_TYPES_VALUES[$session_administrator->type]);

        $tasks = TaskSessionAdministrator::where('session_administrator_id', $session_administrator->id)
                                    ->whereIn('type', ['pre_ca', 'post_ca'])
                                    ->get();
        $filename = Str::slug($session_administrator->libelle). '_'.date('YmdHis') . '.pdf';

        $pdf =  $this->generateFromView( 'pdf.session_administrator.fiche_de_suivi',  [
            'tasks' => $tasks,
            'session_administrator' => $session_administrator,
            'meeting_type' => $meeting_type,
        ],$filename);
        return $pdf;
    }
}

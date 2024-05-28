<?php

namespace App\Http\Controllers\API\V1\Gourvernance\BordDirectors\Sessions;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttendanceListSessionAdministrator\AddAttendanceListSessionAdministratorRequest;
use App\Http\Requests\AttendanceListSessionAdministrator\DeleteAttendanceListSessionAdministratorRequest;
use App\Http\Requests\AttendanceListSessionAdministrator\GeneratePdfAttendanceListSessionAdministratorRequest;
use App\Http\Requests\AttendanceListSessionAdministrator\ListAttendanceListSessionAdministratorRequest;
use App\Http\Requests\AttendanceListSessionAdministrator\UpdateAttendanceListSessionAdministratorRequest;
use App\Models\Gourvernance\BoardDirectors\Sessions\AttendanceListSessionAdministrator;
use App\Models\Gourvernance\BoardDirectors\Sessions\SessionAdministrator;
use App\Repositories\SessionAdministrator\AttendanceListSessionAdministratorRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AttendanceListSessionAdministratorController extends Controller
{
    public function __construct(private AttendanceListSessionAdministratorRepository $attendance) {

    }

    /**
     * Display a listing of the resource.
     */
    public function list(Request $request)
    {
        $attendance_list_session_administrator = $this->attendance->list($request->all());
        return api_response(true, "Liste de présence", $attendance_list_session_administrator , 200);
    }

    /**
     * Add a newly created resource in storage.
     */
    public function updateStatus(UpdateAttendanceListSessionAdministratorRequest $request)
    {
        try {
            $this->attendance->update($request->all());
            return api_response(true, "Succès de l'enregistrement de la liste de présence", '', 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de l'enregistrement de la liste de présence", $e->errors(), 422);
        }
    }

    public function generatePdf(GeneratePdfAttendanceListSessionAdministratorRequest $request) {
        try {

            $session_administrator = SessionAdministrator::find($request['session_administrator_id']);
            $data = $this->attendance->generatePdf($session_administrator);
            return $data;
        } catch (\Throwable $th) {
            return api_error($success = false, 'Une erreur s\'est produite lors de l\'opération', ['server' => $th->getMessage()]);
        }
    }
}

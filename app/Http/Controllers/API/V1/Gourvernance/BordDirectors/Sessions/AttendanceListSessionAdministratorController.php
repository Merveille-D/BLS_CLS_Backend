<?php

namespace App\Http\Controllers\API\V1\Gourvernance\BordDirectors\Sessions;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttendanceListSessionAdministrator\AddAttendanceListSessionAdministratorRequest;
use App\Http\Requests\AttendanceListSessionAdministrator\DeleteAttendanceListSessionAdministratorRequest;
use App\Http\Requests\AttendanceListSessionAdministrator\ListAttendanceListSessionAdministratorRequest;
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
    public function list(ListAttendanceListSessionAdministratorRequest $request)
    {
        $attendance_list_session_administrator = AttendanceListSessionAdministrator::where('session_id', $request->session_id)->get();
        return api_response(true, "Liste de présence", $attendance_list_session_administrator , 200);
    }

    public function generatePdf(ListAttendanceListSessionAdministratorRequest $request) {
        try {

            $session_administrator = SessionAdministrator::find($request['session_id']);
            $data = $this->attendance->generatePdf($session_administrator);
            return $data;
        } catch (\Throwable $th) {
            return api_error($success = false, 'Une erreur s\'est produite lors de l\'opération', ['server' => $th->getMessage()]);
        }
    }

    /**
     * Add a newly created resource in storage.
     */
    public function add(AddAttendanceListSessionAdministratorRequest $request)
    {
        try {
            $this->attendance->add($request->all());
            return api_response(true, "Succès de l'enregistrement de la liste de présence", '', 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de l'enregistrement de la liste de présence", $e->errors(), 422);
        }
    }

    /**
     * Delete the specified resource in storage.
     */
    public function delete(DeleteAttendanceListSessionAdministratorRequest $request)
    {
        try {

            $this->attendance->delete($request->all());
            return api_response(true, "Liste de présence mis à jour avec succès", '', 200);
        } catch (ValidationException $e) {

            return api_response(false, "Echec de la mise à jour de la liste de présence", $e->errors(), 422);
        }
    }
}

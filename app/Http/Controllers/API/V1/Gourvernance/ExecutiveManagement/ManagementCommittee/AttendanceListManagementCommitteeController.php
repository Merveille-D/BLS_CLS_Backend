<?php

namespace App\Http\Controllers\API\V1\Gourvernance\ExecutiveManagement\ManagementCommittee;;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttendanceListManagementCommittee\AddAttendanceListManagementCommitteeRequest;
use App\Http\Requests\AttendanceListManagementCommittee\DeleteAttendanceListManagementCommitteeRequest;
use App\Http\Requests\AttendanceListManagementCommittee\ListAttendanceListManagementCommitteeRequest;
use App\Models\Gourvernance\ExecutiveManagement\ManagementCommittee\AttendanceListManagementCommittee;
use App\Models\Gourvernance\ExecutiveManagement\ManagementCommittee\ManagementCommittee;
use App\Repositories\ManagementCommittee\AttendanceListManagementCommitteeRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AttendanceListManagementCommitteeController extends Controller
{
    public function __construct(private AttendanceListManagementCommitteeRepository $attendance) {

    }

    /**
     * Display a listing of the resource.
     */
    public function list(ListAttendanceListManagementCommitteeRequest $request)
    {
        $attendance_list_management_committee = AttendanceListManagementCommittee::where('session_id', $request->session_id)->get();
        return api_response(true, "Liste de présence", $attendance_list_management_committee , 200);
    }

    public function generatePdf(ListAttendanceListManagementCommitteeRequest $request) {
        try {

            $management_committee = ManagementCommittee::find($request['session_id']);
            $data = $this->attendance->generatePdf($management_committee);
            return $data;
        } catch (\Throwable $th) {
            return api_error($success = false, 'Une erreur s\'est produite lors de l\'opération', ['server' => $th->getMessage()]);
        }
    }

    /**
     * Add a newly created resource in storage.
     */
    public function add(AddAttendanceListManagementCommitteeRequest $request)
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
    public function delete(DeleteAttendanceListManagementCommitteeRequest $request)
    {
        try {

            $this->attendance->delete($request->all());
            return api_response(true, "Liste de présence mis à jour avec succès", '', 200);
        } catch (ValidationException $e) {

            return api_response(false, "Echec de la mise à jour de la liste de présence", $e->errors(), 422);
        }
    }
}

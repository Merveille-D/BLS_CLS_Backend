<?php

namespace App\Http\Controllers\API\V1\Gourvernance\ExecutiveManagement\ManagementCommittee;;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttendanceListManagementCommittee\UpdateAttendanceListManagementCommitteeRequest;
use App\Http\Requests\ManagementCommittee\GeneratePdfManagementCommitteeRequest;
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
    public function list(Request $request)
    {
        $attendance_list_management_committee = $this->attendance->list($request->all());
        return api_response(true, "Liste de présence", $attendance_list_management_committee , 200);
    }


    /**
     * Add a newly created resource in storage.
     */
    public function updateStatus(UpdateAttendanceListManagementCommitteeRequest $request)
    {
        try {
            $this->attendance->update($request->all());
            return api_response(true, "Succès de l'enregistrement de la liste de présence", '', 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de l'enregistrement de la liste de présence", $e->errors(), 422);
        }
    }

    public function generatePdf(GeneratePdfManagementCommitteeRequest $request) {
        try {

            $management_committee = ManagementCommittee::find($request['management_committee_id']);
            $data = $this->attendance->generatePdf($management_committee);
            return $data;
        } catch (\Throwable $th) {
            return api_error($success = false, 'Une erreur s\'est produite lors de l\'opération', ['server' => $th->getMessage()]);
        }
    }

}

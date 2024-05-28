<?php
namespace App\Repositories\SessionAdministrator;

use App\Concerns\Traits\PDF\GeneratePdfTrait;
use App\Models\Gourvernance\BoardDirectors\Administrators\CaAdministrator;
use App\Models\Gourvernance\BoardDirectors\Sessions\AttendanceListSessionAdministrator;
use App\Models\Gourvernance\BoardDirectors\Sessions\SessionAdministrator;
use App\Models\Gourvernance\Representant;

class AttendanceListSessionAdministratorRepository
{
    use GeneratePdfTrait;

    public function __construct(private AttendanceListSessionAdministrator $attendance) {

    }

    public function list() {

        $administrators = CaAdministrator::select('name', 'id')->get()->map(function ($administrator) {
            $administrator->type = "administrator";
            $administrator->status = (empty(AttendanceListSessionAdministrator::where('administrator_id', $administrator->id)->get())) ? false : true ;
            return $administrator;
        });
        $representants = Representant::select('name', 'id')->get()->map(function ($representant) {
            $representant->type = "not_administrator";
            $representant->status = (empty(AttendanceListSessionAdministrator::where('representant_id', $representant->id)->get())) ? false : true ;
            return $representant;
        });

        $administrators = $administrators->merge($representants);

        return $administrators;
    }

    /**
     * @param Request $request
     * @param AttendanceListSessionAdministrator $attendanceListSessionAdministrator
     *
     * @return AttendanceListSessionAdministrator
     */
    public function update($request) {

        foreach ($request['administrators'] as $administrator) {

            if ($administrator['status']) {
                $data = [
                    'session_id' => $request['session_administrator_id']
                ];

                if ($administrator['type'] == 'administrator') {
                    $data['administrator_id'] = $administrator['id'];
                } else {
                    $data['representant_id'] = $administrator['id'];
                }
                $this->attendance->create($data);
            }else {
                $this->attendance->where('session_id', $request['session_administrator_id'])
                                ->where($administrator['type'] == 'administrator' ? 'administrator_id' : 'representant_id', $administrator['id'])
                                ->delete();
            }
        }
        return 0;
    }

    public function generatePdf($session_administrator){

        $meeting_type = SessionAdministrator::SESSION_MEETING_TYPES_VALUES[$session_administrator->type];

        $administrators_id = $session_administrator->attendanceList()->pluck('administrator_id');
        $administrators = CaAdministrator::whereIn('id', $administrators_id)->get();

        $representants_id = $session_administrator->attendanceList()->pluck('representant_id');
        $representants = Representant::whereIn('id', $representants_id)->get();

        $administrators = $administrators->merge($representants);

        $pdf =  $this->generateFromView( 'pdf.session_administrator.attendance',  [
            'administrators' => $administrators,
            'session_administrator' => $session_administrator,
            'meeting_type' => $meeting_type,
        ]);
        return $pdf;
    }
}

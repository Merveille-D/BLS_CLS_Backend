<?php
namespace App\Repositories\ManagementCommittee;

use App\Concerns\Traits\PDF\GeneratePdfTrait;
use App\Models\Gourvernance\ExecutiveManagement\Directors\Director;
use App\Models\Gourvernance\ExecutiveManagement\ManagementCommittee\AttendanceListManagementCommittee;

class AttendanceListManagementCommitteeRepository
{
    use GeneratePdfTrait;

    public function __construct(private AttendanceListManagementCommittee $attendance) {

    }

    /**
     * @param Request $request
     *
     * @return AttendanceListManagementCommittee
     */
    public function add($request) {

        foreach($request['directors'] as $director_id) {
            $this->attendance->create([
                'session_id' => $request['session_id'],
                'director_id' => $director_id,
            ]);
        }
        return 0;
    }

    /**
     * @param Request $request
     * @param AttendanceListManagementCommittee $attendanceListManagementCommittee
     *
     * @return AttendanceListManagementCommittee
     */
    public function delete($request) {

        foreach( $request['directors'] as $director_id) {
            $attendance = $this->attendance
                                ->where('session_id', $request['session_id'])
                                ->where('director_id', $director_id)
                                ->get();
            $attendance->delete();
        }
        return 0;
    }

    public function generatePdf($management_committee){

        $directors_id = $management_committee->attendanceList()->pluck('director_id');
        $directors = Director::whereIn('id', $directors_id)->get();

        $pdf =  $this->generateFromView( 'pdf.management_committee.attendance',  ['directors' => $directors]);
        return $pdf;
    }
}

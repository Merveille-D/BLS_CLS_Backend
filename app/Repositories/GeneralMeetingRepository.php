<?php
namespace App\Repositories;

use App\Models\Gourvernance\GeneralMeeting\GeneralMeeting;
use App\Models\Gourvernance\GourvernanceDocument;

class GeneralMeetingRepository
{
    public function __construct(private GeneralMeeting $meeting) {

    }

    /**
     * @param Request $request
     *
     * @return GeneralMeeting
     */
    public function store($request) {
        $request['reference'] = 'AG-' . date('m') . '-' . date('Y');
        $general_meeting = $this->meeting->create($request->all());
        $general_meeting->status = "pending";

        return $general_meeting;
    }

    /**
     * @param Request $request
     *
     * @return GeneralMeeting
     */
    public function attachement($request) {
        $general_meeting = GeneralMeeting::find($request->general_meeting_id);

        $files = $request->docs['files'];
        $others_files = $request->docs['others_files'];

        foreach ($files as $fieldName => $file) {
            $general_meeting->update([
                $fieldName => uploadFile($file, 'ag_documents'),
                GeneralMeeting::DATE_FILE_FIELD[$fieldName] => now(),
            ]);
        }

        foreach ($others_files as $file) {
            $fileUpload = new GourvernanceDocument();

            $fileUpload->name = $file['name'];
            $fileUpload->file = uploadFile($file['file'], 'ag_documents');
            $fileUpload->status = $general_meeting->status;

            $general_meeting->fileUploads()->save($fileUpload);
        }

        return $general_meeting;
    }
}

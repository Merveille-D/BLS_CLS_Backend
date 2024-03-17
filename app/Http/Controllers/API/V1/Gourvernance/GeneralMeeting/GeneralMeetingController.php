<?php

namespace App\Http\Controllers\API\V1\Gourvernance\GeneralMeeting;

use App\Http\Controllers\Controller;
use App\Models\FileUpload;
use App\Models\Gourvernance\GeneralMeeting\AgActionTypeFile;
use App\Models\Gourvernance\GeneralMeeting\AgAction;
use App\Models\Gourvernance\GeneralMeeting\AgArchiveFile;
use App\Models\Gourvernance\GeneralMeeting\AgPresentShareholder;
use App\Models\Gourvernance\GeneralMeeting\GeneralMeeting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class GeneralMeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $general_meetings = GeneralMeeting::with('actions.actionsTypeFile', 'actions.actionsFile', 'archives', 'shareholders')->get();
        return self::apiResponse(true, "Liste des AG", $general_meetings, 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
            $validate_request =  $request->validate([
                'reference' => ['required', 'string'],
                'meeting_date' => ['required', 'date'],
                'type' => ['required',  Rule::in(GeneralMeeting::GENERAL_MEETING_TYPES) ],
            ]);

            $general_meeting = GeneralMeeting::create($validate_request);

            $actions = AgAction::ACTIONS;

            foreach($actions as $key => $items) {
                foreach($items as $index => $item) {
                    if (isset($item['title'])) {
                        $ag_action = AgAction::create([
                            'title' => $item['title'],
                            'closing_date' => $item['closing_date'],
                            'is_file' => $item['is_file'] ?? false,
                            'general_meeting_id' => $general_meeting->id,
                            'ag_type_id' => $key,
                        ]);

                        if($item['is_file']) {
                            foreach($item['files'] as $file) {
                                AgActionTypeFile::create([
                                    'name' => $file,
                                    'ag_action_id' => $ag_action->id,
                                ]);
                            }
                        }

                    } else {
                        foreach ($item as $subitem) {
                            AgAction::create([
                                'title' => $subitem['title'],
                                'general_meeting_id' => $general_meeting->id,
                                'ag_type_id' => $key,
                                'step_ag_day' => $index,
                            ]);
                        }
                    }
                }
            }

            $general_meeting = $general_meeting->load('actions.actionsTypeFile', 'actions.actionsFile', 'archives', 'shareholders');


            return self::apiResponse(true, "Succès de l'enregistrement de l'AG", $general_meeting, 200);
        }catch (ValidationException $e) {
                return self::apiResponse(false, "Echec de l'enregistrement de l'AG", $e->errors(), 422);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(GeneralMeeting $general_meeting)
    {
        try {

            $general_meeting = $general_meeting->load('actions.actionsTypeFile', 'actions.actionsFile', 'archives', 'shareholders');

            return self::apiResponse(true, "Information de l'AG", $general_meeting, 200);
        }catch( ValidationException $e ) {
            return self::apiResponse(false, "Echec de la récupération des infos de l'AG", $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function saveShareholdersByAg(Request $request) {
        try {
            $validate_request =  $request->validate([
                'general_meeting_id' => ['required', 'numeric'],
                'shareholders_id' => ['required', 'array'],
            ]);

            $old_present_shareholders = AgPresentShareholder::where('general_meeting_id',$validate_request['general_meeting_id'])->delete();

            foreach($validate_request['shareholders_id'] as $item) {
                AgPresentShareholder::create([
                    'shareholder_id' => $item,
                    'general_meeting_id' => $validate_request['general_meeting_id'],
                ]);
            }

            return self::apiResponse(true, "Succès de l'enregistrement des actionnaires", [], 200);
        }catch( ValidationException ) {
            return self::apiResponse(false, "Echec de l'enregistrement des actionnaires", [], 422);
        }
    }

    public function getShareholdersByAg(Request $request) {

        try {
            $validate_request =  $request->validate([
                'general_meeting_id' => ['required', 'numeric'],
            ]);

            $shareholdersByGeneralMeeting = AgPresentShareholder::where('general_meeting_id', $validate_request['general_meeting_id'])->get();
            return self::apiResponse(true, "Actionnaires présent à l'AG", $shareholdersByGeneralMeeting, 200);
        }catch( ValidationException $e ) {
            return self::apiResponse(false, "Echec de la récupération des actionnaires de l'AG", $e->errors(), 422);
        }
    }

    public function saveArchiveFileAg(Request $request) {
        try {
            $validate_request = $request->validate([
                'general_meeting_id' => ['required','numeric'],
                'archives' => ['required','array'],
            ]);

            $general_meeting_id = $validate_request['general_meeting_id'];
            $archives = $validate_request['archives'];

            foreach ($archives as $archive) {

                    AgArchiveFile::create([
                        'name' => $archive['name'],
                        'file' => FileUpload::uploadFile($archive['file'],'ag_archive_files'),
                        'general_meeting_id' => $general_meeting_id,
                    ]);
            }

            return self::apiResponse(true, "Ajout avec succès des archives de l'AG", [], 200);
        }catch( ValidationException $e ) {
            return self::apiResponse(false, "Echec de l'ajout des archives de l'AG", $e->errors(), 422);
        }
    }

    public static function apiResponse($success, $message, $data = [], $status)
    {
        $response = response()->json([
            'success' => $success,
            'message' => $message,
            'body' => $data
        ], $status);
        return $response;
    }
}

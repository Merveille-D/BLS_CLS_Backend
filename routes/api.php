<?php

use App\Http\Controllers\API\V1\Audit\AuditNotationController;
use App\Http\Controllers\API\V1\Audit\AuditPerformanceIndicatorController;
use App\Http\Controllers\API\V1\Audit\AuditPeriodController;
use App\Http\Controllers\API\V1\Bank\BankController;
use App\Http\Controllers\API\V1\Contract\ContractController;
use App\Http\Controllers\API\V1\Contract\ContractModelCategoryController;
use App\Http\Controllers\API\V1\Contract\ContractModelController;
use App\Http\Controllers\API\V1\Contract\PartController;
use App\Http\Controllers\API\V1\Contract\TaskController;
use App\Http\Controllers\API\V1\Evaluation\CollaboratorController;
use App\Http\Controllers\API\V1\Evaluation\EvaluationPeriodController;
use App\Http\Controllers\API\V1\Evaluation\NotationController;
use App\Http\Controllers\API\V1\Evaluation\PerformanceIndicatorController;
use App\Http\Controllers\API\V1\Gourvernance\BankInfo\BankInfoController;
use App\Http\Controllers\API\V1\Gourvernance\BordDirectors\Administrators\AdministratorController;
use App\Http\Controllers\API\V1\Gourvernance\BordDirectors\Sessions\AttendanceListSessionAdministratorController;
use App\Http\Controllers\API\V1\Gourvernance\BordDirectors\Sessions\SessionAdministratorController;
use App\Http\Controllers\API\V1\Gourvernance\BordDirectors\Sessions\TaskSessionAdministratorController;
use App\Http\Controllers\API\V1\Gourvernance\ExecutiveManagement\Directors\DirectorController;
use App\Http\Controllers\API\V1\Gourvernance\ExecutiveManagement\ManagementCommittee\AttendanceListManagementCommitteeController;
use App\Http\Controllers\API\V1\Gourvernance\ExecutiveManagement\ManagementCommittee\ManagementCommitteeController;
use App\Http\Controllers\API\V1\Gourvernance\ExecutiveManagement\ManagementCommittee\TaskManagementCommitteeController;
use App\Http\Controllers\API\V1\Gourvernance\GeneralMeeting\AttendanceListGeneralMeetingController;
use App\Http\Controllers\API\V1\Gourvernance\GeneralMeeting\GeneralMeetingController;
use App\Http\Controllers\API\V1\Gourvernance\GeneralMeeting\TaskGeneralMeetingController;
use App\Http\Controllers\API\V1\Gourvernance\Mandate\MandateController;
use App\Http\Controllers\API\V1\Gourvernance\Representant\RepresentantController;
use App\Http\Controllers\API\V1\Gourvernance\Shareholder\ActionTransferController;
use App\Http\Controllers\API\V1\Gourvernance\Shareholder\ShareholderController;
use App\Http\Controllers\API\V1\Incident\AuthorIncidentController;
use App\Http\Controllers\API\V1\Incident\IncidentController;
use App\Http\Controllers\API\V1\Incident\TaskIncidentController;
use App\Http\Controllers\API\V1\Gourvernance\Shareholder\CapitalController;
use App\Http\Controllers\API\V1\Gourvernance\Shareholder\TaskActionTransferController;
use App\Http\Controllers\API\V1\Gourvernance\Tier\TierController;
use App\Http\Controllers\API\V1\Evaluation\PositionController;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::resource('general_meetings', GeneralMeetingController::class);
    Route::post('ag_attachements', [GeneralMeetingController::class, 'attachment']);
    Route::get('generate_pdf_fiche_suivi_ag', [GeneralMeetingController::class, 'generatePdfFicheSuivi'] );

    Route::resource('task_general_meetings', TaskGeneralMeetingController::class);
    Route::delete('delete_array_task_general_meetings', [TaskGeneralMeetingController::class, 'deleteArrayTaskGeneralMeeting'] );
    Route::put('update_status_task_general_meetings', [TaskGeneralMeetingController::class, 'updateStatusTaskGeneralMeeting'] );
    Route::get('generate_pdf_checklist_and_procedures_ag', [TaskGeneralMeetingController::class, 'generatePdfTasks'] );

    // Liste de présence AG
    Route::get('list_attendance_general_meetings', [AttendanceListGeneralMeetingController::class, 'list'] );
    Route::post('update_attendance_general_meetings', [AttendanceListGeneralMeetingController::class, 'updateStatus'] );
    Route::get('generate_pdf_attendance_general_meetings', [AttendanceListGeneralMeetingController::class, 'generatePdf'] );

    Route::resource('representants', RepresentantController::class);
    Route::resource('tiers', TierController::class);

    // Liste de présence CA
    Route::get('list_attendance_session_administrators', [AttendanceListSessionAdministratorController::class, 'list'] );
    Route::post('update_attendance_session_administrators', [AttendanceListSessionAdministratorController::class, 'updateStatus'] );
    Route::get('generate_pdf_attendance_session_administrators', [AttendanceListSessionAdministratorController::class, 'generatePdf'] );

    // Liste de présence CODIR
    Route::get('list_attendance_management_committees', [AttendanceListManagementCommitteeController::class, 'list'] );
    Route::post('update_attendance_management_committees', [AttendanceListManagementCommitteeController::class, 'updateStatus'] );
    Route::get('generate_pdf_attendance_management_committees', [AttendanceListManagementCommitteeController::class, 'generatePdf'] );


    Route::get('/ca_administrators/settings', [AdministratorController::class, 'settings']);
    Route::resource('/ca_administrators', AdministratorController::class);
    Route::post('renew_mandate_administrator', [AdministratorController::class, 'renewMandate'] );

    Route::resource('session_administrators', SessionAdministratorController::class);
    Route::post('ca_attachements', [SessionAdministratorController::class, 'attachment']);
    Route::get('generate_pdf_fiche_suivi_ca', [SessionAdministratorController::class, 'generatePdfFicheSuivi'] );


    Route::resource('task_session_administrators', TaskSessionAdministratorController::class);
    Route::delete('delete_array_task_session_administrators', [TaskSessionAdministratorController::class, 'deleteArrayTaskSessionAdministrator'] );
    Route::put('update_status_task_session_administrators', [TaskSessionAdministratorController::class, 'updateStatusTaskSessionAdministrator'] );
    Route::get('generate_pdf_checklist_and_procedures_ca', [TaskSessionAdministratorController::class, 'generatePdfTasks'] );


    Route::resource('shareholders', ShareholderController::class);
    Route::resource('action_transfers', ActionTransferController::class);
    Route::resource('task_action_transfers', TaskActionTransferController::class);
    Route::get('get_current_task_action_transfers', [TaskActionTransferController::class, 'getCurrentTaskActionTransfer'] );
    Route::post('complete_task_action_transfers', [TaskActionTransferController::class, 'completeTaskActionTransfer'] );
    Route::get('generate_pdf_certificat_shareholder', [ShareholderController::class, 'generatePdfCertificatShareholder'] );


    Route::post('approved_action_transfers', [ActionTransferController::class, 'approvedActionTransfer'] );

    Route::resource('bank_infos', BankInfoController::class);
    Route::resource('capitals', CapitalController::class);

    // Banque de textes
    Route::resource('banks', BankController::class);

    // Contrats
    Route::resource('contracts', ContractController::class);
    Route::get('get_contract_categories', [ContractController::class, 'getCategories']);
    Route::get('get_contract_type_categories', [ContractController::class, 'getTypeCategories']);
    Route::get('generate_pdf_fiche_suivi_contract', [ContractController::class, 'generatePdfFicheSuivi'] );

    Route::resource('parts', PartController::class);

    Route::resource('contract_models', ContractModelController::class);
    Route::resource('contract_model_categories', ContractModelCategoryController::class);

    Route::resource('tasks', TaskController::class);
    Route::delete('delete_array_task_contracts', [TaskController::class, 'deleteArrayTaskContract'] );
    Route::put('update_status_task_contracts', [TaskController::class, 'updateStatusTaskContract'] );

    // Incidents
    Route::resource('incidents', IncidentController::class);
    Route::get('generate_pdf_fiche_suivi_incident', [IncidentController::class, 'generatePdfFicheSuivi'] );
    Route::resource('author_incidents', AuthorIncidentController::class);
    Route::resource('task_incidents', TaskIncidentController::class);
    Route::get('get_current_task_incidents', [TaskIncidentController::class, 'getCurrentTaskIncident'] );
    Route::post('complete_task_incidents', [TaskIncidentController::class, 'completeTaskIncident'] );


    // DIRECTION GENERALE
    Route::resource('directors', DirectorController::class);
    Route::post('renew_mandate_director', [DirectorController::class, 'renewMandate'] );

    //Mandats
    Route::resource('mandates', MandateController::class);

    Route::resource('management_committees', ManagementCommitteeController::class);
    Route::post('cd_attachements', [ManagementCommitteeController::class, 'attachment']);
    Route::get('generate_pdf_fiche_suivi_codir', [ManagementCommitteeController::class, 'generatePdfFicheSuivi'] );

    Route::resource('task_management_committees', TaskManagementCommitteeController::class);
    Route::delete('delete_array_task_management_committees', [TaskManagementCommitteeController::class, 'deleteArrayTaskManagementCommittee'] );
    Route::put('update_status_task_management_committees', [TaskManagementCommitteeController::class, 'updateStatusTaskManagementCommittee'] );
    Route::get('generate_pdf_checklist_and_procedures_codir', [TaskManagementCommitteeController::class, 'generatePdfTasks'] );


    // EVALUATION
    Route::resource('notations', NotationController::class);
    Route::get('generate_pdf_fiche_suivi_evaluation', [NotationController::class, 'generatePdfFicheSuivi'] );
    Route::resource('performance_indicators', PerformanceIndicatorController::class);
    Route::resource('collaborators', CollaboratorController::class);
    Route::post('evaluation_create_transfers', [NotationController::class, 'createTransfer'] );
    Route::resource('positions', PositionController::class);

    // AUDIT
    Route::resource('audit_notations', AuditNotationController::class);
    Route::resource('audit_periods', AuditPeriodController::class);
    Route::get('generate_pdf_fiche_suivi_audit', [AuditNotationController::class, 'generatePdfFicheSuivi'] );
    Route::resource('audit_performance_indicators', AuditPerformanceIndicatorController::class);
    Route::resource('audit_performance_indicators', AuditPerformanceIndicatorController::class);
    Route::post('audit_create_transfers', [AuditNotationController::class, 'createTransfer'] );

});









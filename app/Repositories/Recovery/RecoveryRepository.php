<?php
namespace App\Repositories\Recovery;

use App\Concerns\Traits\Recovery\RecoveryFormFieldTrait;
use App\Enums\Recovery\RecoveryStepEnum;
use App\Http\Resources\Recovery\RecoveryResource;
use App\Http\Resources\Recovery\RecoveryStepResource;
use App\Models\Recovery\Recovery;
use App\Models\Recovery\RecoveryDocument;
use App\Models\Recovery\RecoveryStep;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Str;

class RecoveryRepository
{
    use RecoveryFormFieldTrait;
    public function __construct(
        private Recovery $recovery_model
    ) {
    }


    public function getList($request) : ResourceCollection {
        return RecoveryResource::collection($this->recovery_model->paginate());
    }

    public function findById($id) : JsonResource {
        return new RecoveryResource($this->recovery_model->with('documents')->findOrFail($id));
    }


    public function getSteps($recoveryId, $request) {
        $recoveryId = $this->recovery_model->findOrFail($recoveryId);

        $steps = ($recoveryId->steps);
        $type = $request->type;

        $steps->transform(function ($step) {
            $step->status = $step->status ? true : false;
            $form = $this->getCustomFormFields($step->code);
            if ($form) {
                $step->form = $form;
            }
            return $step;
        });

        return RecoveryStepResource::collection($steps);
        // return new RecoveryResource($this->recovery_model->with('documents')->findOrFail($id));
    }

    function addNewTask($request, $recoveryId) : JsonResource {
        $recovery = $this->recovery_model->findOrFail($recoveryId);
        $task = new RecoveryStep();
        $task->name = $request->name;
        $task->code = 'task';
        $task->type = 'task';
        $task->save();
        $recovery->steps()->save($task, [
            'type' => 'task',
            'deadline' => $request->deadline,
        ]);
        return new RecoveryStepResource($task);
    }

    public function updateTask($request, $recoveryId, $taskId) {
        $recovery = $this->recovery_model->findOrFail($recoveryId);
        $task = ($recovery->steps)->where('id', $taskId)->first();
        $task->name = $request->name;
        $task->save();
        $recovery->steps()->updateExistingPivot($taskId, [
            'type' => 'task',
            'deadline' => $request->deadline,
        ]);
        $task = $recovery->steps()->where('recovery_steps.id', $taskId)->first();
        return new RecoveryStepResource($task);
    }

    public function completeTask($recoveryId, $taskId) : JsonResource {
        $recovery = $this->recovery_model->findOrFail($recoveryId);
        $task = ($recovery->steps)->where('id', $taskId)->first();
        $recovery->steps()->updateExistingPivot($task->id, [
            'type' => 'task',
            'status' => true,
        ]);
        $task = $recovery->steps()->where('recovery_steps.id', $taskId)->first();
        return new RecoveryStepResource($task);
    }

    public function deleteTask($recoveryId, $taskId) {
        $recovery = $this->recovery_model->findOrFail($recoveryId);
        $recovery->steps()->detach($taskId);
        return true;
    }

    public function getOneStep($recovery_id, $step_id) {
        $recovery = $this->recovery_model->findOrFail($recovery_id);

        $step = ($recovery->steps)->where('id', $step_id)->first();
        $form = $this->getCustomFormFields($step->code);
        if ($form) {
            $step->form = $form;
        }
        $step->status = $step->status ? true : false;
        return new RecoveryStepResource($step);
    }

    function init($request) {
        $data = array(
            'status' => 'created',
            'type' => $request->type,
            'reference' => generateReference('REC'),
            'name' => $request->name,
            'has_guarantee' => $request->has_guarantee ?? 0,
            'guarantee_id' => $request->guarantee_id ?? null
            // 'contract_file' =>  $file_path,
            // 'contract_id' =>  $request->contract_id,
        );

        $recovery = $this->recovery_model->create($data);

        $all_steps = RecoveryStep::orderBy('rank')
            ->when($recovery->has_guarantee == false, function ($query) use ($recovery){
                return $query->whereType($recovery->type)
                            ->when($recovery->type == 'forced', function($query) {
                                $query->where('rank', '<=', '3');
                            });
            }, function($query) {
                return $query->whereType('unknown');
            })
            ->get();

        $recovery->steps()->syncWithoutDetaching($all_steps);
        $this->updatePivotState($recovery);

        return new RecoveryResource($recovery);
    }

    public function continueForcedProcess($recovery) {
        if ($recovery->payement_status) {
            $end_steps = RecoveryStep::orderBy('rank')
                    ->whereType('forced')
                    ->where('rank', '>', 3)
                    ->get();

            $recovery->steps()->syncWithoutDetaching($end_steps);
        }
    }

    public function updatePivotState($recovery) {
        $currentStep = $recovery->next_step; //because the current step is not  updated yet
        if ($currentStep) {
            $pivotValues = [
                $currentStep->id => [
                    'status' => true,
                ]
            ];
            $recovery->steps()->syncWithoutDetaching($pivotValues);
        }

        $this->continueForcedProcess($recovery);
    }

    public function updateProcess($request, $recovery) {

        $data = array();

        if ($recovery) {
            $data = $this->updateProcessByState($request, $recovery);

            $this->updatePivotState($recovery);
            return new RecoveryResource($data);
        }
    }

    function updateProcessByState($request, $recovery) {
        $data = array();

        switch ($recovery->status) {
            case RecoveryStepEnum::CREATED:
                $data = $this->formalNotice($request, $recovery);
                break;

            case RecoveryStepEnum::FORMAL_NOTICE:
                $data = $this->debtPayement($request, $recovery);
                break;
            case RecoveryStepEnum::DEBT_PAYEMENT:
                $data = $this->jurisdiction($request, $recovery);
                break;
            case RecoveryStepEnum::JURISDICTION:
                $data = $this->seizure($request, $recovery);
                break;
            case RecoveryStepEnum::SEIZURE:
                $data = $this->executory($request, $recovery);
                break;
            case RecoveryStepEnum::EXECUTORY:
                $data = $this->entrustLawyer($request, $recovery);
                break;

            default:
                # code...
                break;
        }
        $recovery->update($data);
        return $recovery->refresh();
    }

    function formalNotice($request, $recovery) : array {
        $status = RecoveryStepEnum::FORMAL_NOTICE;
        $data = array(
            'status' => $status,
        );

        return $this->stepCommonSavingSettings(
            $files = $request->documents,
            $recovery = $recovery,
            $data = $data
        );
    }

    function debtPayement($request, $recovery) : array {
        $status = RecoveryStepEnum::DEBT_PAYEMENT;
        return $data = array(
            'status' => $status,
            'payement_status' => $request->payement_status
        );
    }

    function jurisdiction($request, $recovery) : array {
        $status = RecoveryStepEnum::JURISDICTION;
        $data = array(
            'status' => $status,
        );

        return $this->stepCommonSavingSettings(
            $files = $request->documents,
            $recovery = $recovery,
            $data = $data
        );
    }

    function seizure($request, $recovery) : array {
        $status = RecoveryStepEnum::SEIZURE;
        $data = array(
            'status' => $status,
        );

        return $this->stepCommonSavingSettings(
            $files = $request->documents,
            $recovery = $recovery,
            $data = $data
        );
    }

    function executory($request, $recovery) : array {
        $status = RecoveryStepEnum::EXECUTORY;
        $data = array(
            'status' => $status,
        );

        return $this->stepCommonSavingSettings(
            $files = $request->documents,
            $recovery = $recovery,
            $data = $data
        );
    }

    function entrustLawyer($request, $recovery) : array {
        $status = RecoveryStepEnum::ENTRUST_LAWYER;
        $data = array(
            'status' => $status,
        );

        return $this->stepCommonSavingSettings(
            $files = $request->documents,
            $recovery = $recovery,
            $data = $data
        );
    }

    function stepCommonSavingSettings($files,Model $recovery, array $data) : array {
        if (count($files)<=0)
            return false;

        foreach ($files as $key => $file_elt) {

            $file_path = $this->storeFile($file_elt['file']);

            $doc = new RecoveryDocument();
            $doc->status = $data['status'];
            $doc->file_name = $file_elt['name'];
            $doc->file_path = $file_path;

            $recovery->documents()->save($doc);
        }

        //check files are saved correctly before changing state
        $check_files = $recovery->documents()->whereStatus($data['status'])->get();
        if ($check_files->count() > 0) {
            return $data;
        } else {
            return [];
        }

    }


    function storeFile($file) {
        if($file) {
            $sanitized_file_name = date('Y-m-d_His-').Str::random(6).auth()->id().'-'.sanitize_file_name($file->getClientOriginalName());
            $path = $file->storeAs('guarantee/conventionnal_hypothec', $sanitized_file_name);
            return $path;
        }
    }
}

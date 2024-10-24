<?php

namespace App\Repositories\Recovery;

use App\Concerns\Traits\PDF\GeneratePdfTrait;
use App\Concerns\Traits\Recovery\RecoveryFormFieldTrait;
use App\Enums\Recovery\RecoveryStepEnum;
use App\Http\Resources\Recovery\RecoveryResource;
use App\Http\Resources\Recovery\RecoveryStepResource;
use App\Models\Guarantee\ConvHypothec;
use App\Models\Guarantee\Guarantee;
use App\Models\Recovery\Recovery;
use App\Models\Recovery\RecoveryDocument;
use App\Models\Recovery\RecoveryStep;
use App\Models\Recovery\RecoveryTask;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Str;

class RecoveryRepository
{
    use GeneratePdfTrait, RecoveryFormFieldTrait;

    public function __construct(
        private Recovery $recovery_model
    ) {}

    public function getList($request): ResourceCollection
    {
        return RecoveryResource::collection($this->recovery_model->paginate());
    }

    public function findById($id): JsonResource
    {
        return new RecoveryResource($this->recovery_model->with('documents')->findOrFail($id));
    }

    public function getSteps($recoveryId, $request)
    {
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

    public function addNewTask($request, $recoveryId): JsonResource
    {
        $recovery = $this->recovery_model->findOrFail($recoveryId);
        $task = new RecoveryStep;
        $task->name = $request->name;
        $task->code = 'task';
        $task->type = 'task';
        $task->save();
        $recovery->steps()->save($task, [
            'type' => 'task',
            'deadline' => $request->deadline,
        ]);

        $task = $recovery->steps()->where('recovery_steps.id', $task->id)->first();

        return new RecoveryStepResource($task);
    }

    public function updateTask($request, $recoveryId, $taskId)
    {
        $recovery = $this->recovery_model->findOrFail($recoveryId);
        $task = ($recovery->steps)->where('id', $taskId)->first();
        if (! $task) {
            return false;
        }
        $task->name = $request->name;
        $task->save();
        $recovery->steps()->updateExistingPivot($taskId, [
            'type' => 'task',
            'deadline' => $request->deadline,
        ]);
        $task = $recovery->steps()->where('recovery_steps.id', $taskId)->first();

        return new RecoveryStepResource($task);
    }

    public function completeTask($recoveryId, $taskId): JsonResource
    {
        $recovery = $this->recovery_model->findOrFail($recoveryId);
        $task = ($recovery->steps)->where('id', $taskId)->first();
        $recovery->steps()->updateExistingPivot($task->id, [
            'type' => 'task',
            'status' => true,
        ]);
        $task = $recovery->steps()->where('recovery_steps.id', $taskId)->first();

        return new RecoveryStepResource($task);
    }

    public function deleteTask($recoveryId, $taskId)
    {
        $recovery = $this->recovery_model->findOrFail($recoveryId);
        $recovery->steps()->detach($taskId);

        return true;
    }

    public function getOneStep($recovery_id, $step_id)
    {
        $recovery = $this->recovery_model->findOrFail($recovery_id);

        $step = ($recovery->steps)->where('id', $step_id)->first();
        $form = $this->getCustomFormFields($step->code);
        if ($form) {
            $step->form = $form;
        }
        $step->status = $step->status ? true : false;

        return new RecoveryStepResource($step);
    }

    public function init($request)
    {
        $data = [
            'status' => 'created',
            'type' => $request->type,
            'reference' => generateReference('REC', $this->recovery_model),
            'name' => $request->name,
            'has_guarantee' => $request->has_guarantee ?? 0,
            'guarantee_id' => $request->guarantee_id ?? null,
            'contract_id' => $request->contract_id ?? null,
            'created_by' => auth()->id(),
        ];

        $recovery = $this->recovery_model->create($data);

        if ($recovery->guarantee_id) {
            $this->updateHypothecStatus($recovery, $request);
        }

        $this->generateSteps($recovery);

        $this->updateTaskState($recovery);

        return new RecoveryResource($recovery);
    }

    public function generateSteps($recovery)
    {
        $all_steps = RecoveryStep::orderBy('rank')
            ->when($recovery->has_guarantee == false, function ($query) use ($recovery) {
                return $query->whereType($recovery->type)
                    ->when($recovery->type == 'forced', function ($query) {
                        $query->where('rank', '<=', '3');
                    });
            }, function ($query) {
                return $query->whereType('unknown');
            })
            ->get();

        return $this->saveTasks($all_steps, $recovery);

        // return $recovery->steps()->syncWithoutDetaching($all_steps);
    }

    public function saveTasks($steps, $recovery)
    {
        foreach ($steps as $key => $step) {
            $task = new RecoveryTask;
            $task->code = $step->code;
            $task->title = $step->title;
            $task->rank = $step->rank;
            $task->type = 'recovery';
            $task->step_id = $step->id;
            $task->max_deadline = $step->code == 'created' ? now() : null;
            $task->created_by = auth()->id();

            $task->taskable()->associate($recovery);
            $task->save();
        }
    }

    public function continueForcedProcess($recovery)
    {
        if (! $recovery->payement_status && $recovery->status == RecoveryStepEnum::DEBT_PAYEMENT) {
            $end_steps = RecoveryStep::orderBy('rank')
                ->whereType('forced')
                ->where('rank', '>', 3)
                ->get();

            $this->saveTasks($end_steps, $recovery);
        }
    }

    public function updateTaskState($recovery)
    {
        $currentTask = $recovery->next_task;
        // dd($currentTask);
        if ($currentTask) {
            $currentTask->status = true;
            if ($currentTask->completed_at == null) {
                $currentTask->completed_at = Carbon::now();
            }
            $currentTask->save();
        }

        $nextTask = $recovery->next_task;
        if ($nextTask) {
            $data = $this->setDeadline($recovery);

            if ($data == []) {
                return false;
            }

            $nextTask->update($data);
        }

        $this->continueForcedProcess($recovery);
    }

    public function updateProcess($request, $recovery)
    {

        $data = [];

        if ($recovery) {
            $data = $this->updateProcessByState($request, $recovery);

            $this->updateTaskState($recovery);

            return new RecoveryResource($data);
        }
    }

    public function updateProcessByState($request, $recovery)
    {
        $data = [];

        switch ($recovery->status) {
            case RecoveryStepEnum::CREATED:
                $data = $this->formalNotice($request, $recovery);
                break;

            case RecoveryStepEnum::FORMAL_NOTICE:
                $data = $this->debtPayement($request, $recovery);
                break;
            case RecoveryStepEnum::DEBT_PAYEMENT:
                $data = $this->seizure($request, $recovery);
                break;
            case RecoveryStepEnum::SEIZURE:
                $data = $this->executory($request, $recovery);
                break;
            case RecoveryStepEnum::EXECUTORY:
                $data = $this->jurisdiction($request, $recovery);
                break;
            case RecoveryStepEnum::JURISDICTION:
                $data = $this->entrustLawyer($request, $recovery);
                break;

            default:
                // code...
                break;
        }
        $recovery->update($data);

        return $recovery->refresh();
    }

    public function formalNotice($request, $recovery): array
    {
        $status = RecoveryStepEnum::FORMAL_NOTICE;
        $data = [
            'status' => $status,
        ];

        return $this->stepCommonSavingSettings(
            $files = $request->documents,
            $recovery = $recovery,
            $data = $data
        );
    }

    public function debtPayement($request, $recovery): array
    {
        $status = RecoveryStepEnum::DEBT_PAYEMENT;

        return $data = [
            'status' => $status,
            'payement_status' => $request->payement_status == 'yes' ? true : false,
        ];
    }

    public function jurisdiction($request, $recovery): array
    {
        $status = RecoveryStepEnum::JURISDICTION;
        $data = [
            'status' => $status,
        ];

        return $this->stepCommonSavingSettings(
            $files = $request->documents,
            $recovery = $recovery,
            $data = $data
        );
    }

    public function seizure($request, $recovery): array
    {
        $status = RecoveryStepEnum::SEIZURE;
        $data = [
            'status' => $status,
            'is_seized' => $request->is_seized == 'yes' ? true : false,
        ];

        return $data;
    }

    public function executory($request, $recovery): array
    {
        $status = RecoveryStepEnum::EXECUTORY;
        $data = [
            'status' => $status,
        ];

        return $this->stepCommonSavingSettings(
            $files = $request->documents,
            $recovery = $recovery,
            $data = $data
        );
    }

    public function entrustLawyer($request, $recovery): array
    {
        $status = RecoveryStepEnum::ENTRUST_LAWYER;
        $data = [
            'status' => $status,
            $request->is_entrusted == 'yes' ? true : false,
        ];

        return $data;
    }

    public function stepCommonSavingSettings($files, Model $recovery, array $data): array
    {
        if (count($files) <= 0) {
            return false;
        }

        foreach ($files as $key => $file_elt) {

            $file_path = storeFile($file_elt['file'], 'recovery');

            $doc = new RecoveryDocument;
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

    public function archive($id): JsonResource
    {
        $recovery = $this->findById($id);
        $recovery->update([
            'is_archived' => ! $recovery->is_archived,
        ]);

        return new RecoveryResource($recovery);
    }

    // union query of guarantee and conv_hypothec
    public function getRealizableGuarantees()
    {
        $hypothecs = ConvHypothec::where('has_recovery', false)->select('id', 'reference', 'name', 'created_at')
            ->selectRaw("'hypothec' as type");
        $guarantees = Guarantee::where('has_recovery', false)->select('id', 'reference', 'type', 'name', 'created_at');

        $union = $guarantees->union($hypothecs)->orderByDesc('created_at')->get();

        return $union;
    }

    public function updateHypothecStatus($recovery, $request)
    {

        $guarantee = Guarantee::find($recovery->guarantee_id);

        if ($guarantee) {
            $guarantee->update([
                'has_recovery' => true,
            ]);
        }
    }

    public function setDeadline($recovery)
    {
        $nextTask = $recovery->next_task;
        $defaultTask = $nextTask?->step;

        $minDelay = $defaultTask->min_delay;
        $maxDelay = $defaultTask->max_delay;
        // dd($minDelay, $maxDelay);
        $data = [];
        //date by hypothec state
        // $operationDate = $this->getOperationDateByState($guarantee);
        $operationDate = $recovery->current_task->completed_at ?? null;
        if ($operationDate == null) {
            return $data;
        }

        $operationDate = substr($operationDate, 0, 10);
        $formatted_date = Carbon::createFromFormat('Y-m-d', $operationDate);

        if ($minDelay && $maxDelay) {
            $data['min_deadline'] = $formatted_date->copy()->addDays($minDelay);
            $data['max_deadline'] = $formatted_date->copy()->addDays($maxDelay);

            return $data;
        } elseif ($minDelay) {
            $data['min_deadline'] = $formatted_date->addDays($minDelay);

            return $data;
        } elseif ($maxDelay) {
            $data['max_deadline'] = $formatted_date->addDays($maxDelay);

            return $data;
        }

        return $data;
    }

    public function generatePdf($id)
    {
        $recovery = $this->recovery_model->findOrFail($id);
        $filename = Str::slug($recovery->name) . '_' . date('YmdHis') . '.pdf';

        $pdf = $this->generateFromView('pdf.recovery.recovery', [
            'model' => $recovery,
            'details' => $this->getDetails($recovery),
        ],
            $filename);

        return $pdf;

    }

    public function getDetails($recovery)
    {
        $details = [
            'Référence' => $recovery->reference,
            'type' => $recovery->readable_type,
            'Intitulé' => $recovery->name ?? null,
        ];

        return $details;
    }
}

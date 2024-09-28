<?php

namespace App\Repositories\Guarantee;

use App\Concerns\Traits\PDF\GeneratePdfTrait;
use App\Enums\Guarantee\GuaranteeType;
use App\Http\Resources\Guarantee\GuaranteeResource;
use App\Http\Resources\Guarantee\GuaranteeTaskResource;
use App\Models\Guarantee\Guarantee;
use App\Models\Guarantee\GuaranteeStep;
use App\Models\Guarantee\GuaranteeTask;
use App\Models\Guarantee\HypothecTask;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Str;

class GuaranteeRepository
{
    use GeneratePdfTrait;
    public function __construct(
        private Guarantee $guarantee_model
    ) {
    }
    public function getList($request) : ResourceCollection {
        $guarantees = $this->guarantee_model->with('tasks')
            ->when($request->security == 'personal', function ($query) {
                return $query->whereSecurity('personal');
            })
            ->when($request->security == 'movable', function ($query) {
                return $query->whereIn('security', ['pledge', 'collateral']);
            })
            //mortgage guarantees
            ->when($request->security == 'property', function ($query) {
                return $query->whereSecurity('property');
            })
            //get all guarantees based on phase
            ->when($request->phase, function ($query, $phase) {
                return $query->where('phase', $phase);
            })
            // retrieve based on type
            ->when($request->type, function ($query, $type) {
                return $query->where('type', $type);
            })
            ->when($request->search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('reference', 'like', '%' . $search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(DEFAULT_DATA_LIMIT);
        return GuaranteeResource::collection($guarantees);
    }

    public function add($request): JsonResource
    {
        $data = array(
            'type' => $request->type,
            'phase' => 'formalization',
            'reference' => generateReference(GuaranteeType::CODES[$request->type] , $this->guarantee_model),
            'name' => $request->name,
            'contract_id' =>  $request->contract_id,
            'created_by' => auth()->id(),
        );
        if ($request->security)
            $data['security'] = $request->security;
        if ($request->formalization_type)
            $data['extra'] = ['formalization_type' => $request->formalization_type];
        if ($request->autonomous_id)
            $data['extra'] = ['autonomous_id' => $request->autonomous_id];

        $guarantee = $this->guarantee_model->create($data);
        // dd($guarantee->type);
        $steps = GuaranteeStep::whereGuaranteeType($guarantee->type)
                    ->whereStepType('formalization')
                    ->whereNull('parent_id')
                    ->when($guarantee->type == 'stock' || $guarantee->security == 'collateral' , function ($query) use ($request) {
                        return $query->whereFormalizationType($request->formalization_type);
                    })
                    ->get();

        $this->saveTasks($steps, $guarantee);
        $this->updateTaskState($guarantee);

        return new GuaranteeResource($guarantee->refresh());
    }

    public function getOne($guarantee): ?JsonResource
    {
        // $guarantee = $this->guarantee_model->findOrFail($id);

        return new GuaranteeResource($guarantee);
    }

    public function edit($guarantee, $request): bool
    {
        return $guarantee->update($request->all());
    }

    public function delete(string $id): bool
    {
        $guarantee = $this->guarantee_model->findOrFail($id);

        return $guarantee->delete();
    }

    public function saveTasks($steps, $guarantee) {
        $past_task_deadline = null;
        foreach ($steps as $key => $step) {
            $past_task_deadline = Carbon::parse($past_task_deadline)->addDays($step->max_delay);
            $task = new GuaranteeTask();
            $task->code = $step->code;
            $task->title = $step->title;
            $task->step_id = $step->id;
            $task->rank = $step->rank;
            $task->type = $step->step_type;
            if($guarantee->security == 'property') {
                $task->max_deadline = $past_task_deadline;
            }else {
                $task->max_deadline = $step->code == 'created' ? now() : null;
            }
            $task->created_by = auth()->id();

            $task->taskable()->associate($guarantee);
            $task->save();
        }
    }

    public function updateTaskState($guarantee) {
        $currentTask = $guarantee->next_task;
        // dd($currentTask);
        if ($currentTask) {
            $currentTask->status = true;
            $currentTask->completed_by = auth()->id();
            if ($currentTask->completed_at == null)
                $currentTask->completed_at = Carbon::now();
            $currentTask->save();
        }

        //for mortgage only
        if ($guarantee->security == 'property') {
            $next_tasks = $guarantee->next_tasks;
            $past_task_deadline = $currentTask->completed_at;
            foreach ($next_tasks as $key => $task) {
                $past_task_deadline = Carbon::parse($past_task_deadline)->addDays($task?->step?->max_delay);

                $task->max_deadline = $past_task_deadline;
                $task->save();
            }
            return;
        }

        $nextTask = $guarantee->next_task;
        if ($nextTask) {
            $data = $this->setDeadline($guarantee);

            if ($data == [])
                return false;

            $nextTask->update($data);
        }
    }

    function setDeadline($guarantee) {
        $nextTask = $guarantee->next_task;
        $defaultTask = GuaranteeStep::where('code', $nextTask->code)->first();

        $minDelay = $defaultTask->min_delay;
        $maxDelay = $defaultTask->max_delay;
        // dd($minDelay, $maxDelay);
        $data = array();
        //date by hypothec state
        // $operationDate = $this->getOperationDateByState($guarantee);
        $operationDate = $guarantee->current_task->completed_at ?? null;
        if ($operationDate == null)
            return $data;

        $operationDate = substr($operationDate, 0, 10);
        $formatted_date = Carbon::createFromFormat('Y-m-d', $operationDate);

        if ($minDelay && $maxDelay) {
            $data['min_deadline'] = $formatted_date->copy()->addDays($minDelay);
            $data['max_deadline'] = $formatted_date->copy()->addDays($maxDelay);
            return $data;
        }elseif ($minDelay) {
            $data['min_deadline'] = $formatted_date->addDays($minDelay);
            return $data;
        }elseif ($maxDelay) {
            $data['max_deadline'] = $formatted_date->addDays($maxDelay);
            return $data;
        }
        return $data;
    }

    public function realization($guarantee) {
        if (!$guarantee->has_recovery)
            return;

        $steps = GuaranteeStep::whereNull('parent_id')->whereGuaranteeType($guarantee->type)->whereStepType('realization')->get();

        $this->saveTasks($steps, $guarantee);

            $guarantee->phase = 'realization';
            $guarantee->save();

        return GuaranteeTaskResource::collection($guarantee->tasks);
    }

    public function generatePdf($id) {
        $guarantee = $this->guarantee_model->findOrFail($id);
        $filename = Str::slug($guarantee->name). '_'.date('YmdHis') . '.pdf';

        $pdf =  $this->generateFromView( 'pdf.guarantee.guarantee',  [
            'model' => $guarantee,
            'details' => $this->getDetails($guarantee)
        ],
        $filename);

        return $pdf;
    }

    public function getDetails($guarantee) {
        $details = [
            'Référence' => $guarantee->reference,
            'Type' => $guarantee->readable_type,
            'Intitulé' => $guarantee->name ?? null,
            'Phase' => $guarantee->readable_phase,
        ];

        if ($guarantee->security == 'property' && $guarantee->phase == 'realization') {
            $details['Date de vente fixée'] = $guarantee->extra['date_sell'] ?? null;
            $details['Prix de vente'] = $guarantee->extra['sell_price_estate'] ?? null;
        }

        return $details;
    }
}

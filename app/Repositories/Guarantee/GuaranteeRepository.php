<?php

namespace App\Repositories\Guarantee;

use App\Http\Resources\Guarantee\GuaranteeResource;
use App\Models\Guarantee\Guarantee;
use App\Models\Guarantee\GuaranteeStep;
use App\Models\Guarantee\GuaranteeTask;
use App\Models\Guarantee\HypothecTask;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class GuaranteeRepository
{
    public function __construct(
        private Guarantee $guarantee_model
    ) {
    }
    public function getList($request) : ResourceCollection {
        return GuaranteeResource::collection(Guarantee::all());
    }

    public function add($request): JsonResource
    {
        $data = array(
            'type' => $request->type,
            'reference' => generateReference('GA', $this->guarantee_model),
            'name' => $request->name,
            'contract_id' =>  $request->contract_id,
        );
        $guarantee = $this->guarantee_model->create($data);
        $steps = GuaranteeStep::orderBy('rank')->whereGuaranteeType($guarantee->type)->whereStepType('formalization')->get();

        $this->saveTasks($steps, $guarantee);

        return new GuaranteeResource($guarantee);
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

    public function saveTasks($steps, $convHypo) {
        foreach ($steps as $key => $step) {
            $task = new GuaranteeTask();
            $task->code = $step->code;
            $task->title = $step->title;
            $task->rank = $step->rank;
            $task->type = $step->step_type;
            $task->created_by = auth()->id();

            // $task->min_deadline = $step->min_delay ?? null;
            // $task->max_deadline = $step->max_delay ?? null;

            $task->taskable()->associate($convHypo);
            $task->save();
            // HypothecTask::create($step->toArray());
        }
    }
}

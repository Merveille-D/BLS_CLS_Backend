<?php

namespace App\Http\Resources\Guarantee;

use App\Http\Resources\Transfer\TransferResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GuaranteeTaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dd($this->form);
        return [
            'id' => $this->id,
            'code' => $this->code,
            'title' => $this->title,
            'status' => $this->status,
            'min_deadline' => $this->min_deadline,
            'max_deadline' => $this->max_deadline,
            'type' => $this->type,
            'model_id' => $this->when($this->taskable, $this->taskable?->id),
            // 'taskable' => $this->when($this->taskable, $this->taskable),
            // 'deadline' => $this->deadline,
            'created_by' => $this->created_by,
            'completed_at' => $this->completed_at,
            // 'next_step' => $this->taskable?->next_task,
            // 'current_step' => $this->taskable?->current_task,
            'form' => $this->when($this->form, $this->form),
            'transfers' => $this->when($this->transfers, TransferResource::collection($this->transfers)),
        ];
    }
}

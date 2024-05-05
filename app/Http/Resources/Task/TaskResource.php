<?php

namespace App\Http\Resources\Task;

use App\Http\Resources\Transfer\TransferResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'title' => $this->title,
            'status' => $this->status,
            'min_deadline' => $this->completed_min_date, //$this->min_deadline,
            'max_deadline' => $this->completed_max_date, //$this->max_deadline,
            'type' => $this->type,
            'taskable' => $this->when($this->taskable, $this->taskable),
            // 'deadline' => $this->deadline,
            'form' => $this->when($this->form, $this->form),
            'created_by' => $this->created_by,
            'transfers' => $this->when($this->transfers, TransferResource::collection($this->transfers)),
        ];
    }
}

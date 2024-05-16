<?php

namespace App\Http\Resources\Guarantee;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GuaranteeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $id = $request->route('guarantee');
        return [
            'id' => $this->id,
            'status' => $this->status, // 'created', ...
            'reference' => $this->reference,
            'name' => $this->name,
            'security' => $this->when($this->security, $this->security),
            'type' => $this->type,
            'phase' => $this->phase,
            'contract_id' => $this->contract_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'next_step' => $this->when($id, new GuaranteeTaskResource($this->next_task)),
            'current_step' => $this->when($id, new GuaranteeTaskResource($this->current_task)),
            'documents' => $this->when($id, DocumentResource::collection($this->documents)),
            'is_archived' => $this->is_archived,
            'has_recovery' => $this->has_recovery,
            'extra' => $this->when($this->extra, $this->extra),
        ];
    }
}

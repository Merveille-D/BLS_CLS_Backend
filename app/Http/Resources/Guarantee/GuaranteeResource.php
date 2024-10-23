<?php

namespace App\Http\Resources\Guarantee;

use App\Enums\Guarantee\GuaranteeType;
use App\Http\Resources\Transfer\TransferResource;
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
            'created_by' => $this->created_by,
            // mortage especial fields
            'sell_price_estate' => $this->when($this->type == 'mortgage', $this->extra['sell_price_estate'] ?? null),
            'is_approved' =>  $this->when($this->type == 'mortgage', $this->extra['is_approved'] ?? false),
            // movable especial fields
            'formalization_type' => $this->when($this->security == 'movable', $this->extra['formalization_type'] ?? null),
            // autonomous_counter especial fields
            'autonomous_id' => $this->when($this->type == GuaranteeType::AUTONOMOUS_COUNTER, $this->extra['autonomous_id'] ?? null),
            'transfers' => TransferResource::collection($this->transfers),
            'next_step' => $this->when($id, new GuaranteeTaskResource($this->next_task)),
            'current_step' => $this->when($id, new GuaranteeTaskResource($this->current_task)),
            'documents' => $this->when($id, DocumentResource::collection($this->documents)),
            'is_archived' => $this->is_archived,
            'has_recovery' => $this->has_recovery,
            'extra' => $this->when($this->extra, $this->extra),
        ];
    }
}

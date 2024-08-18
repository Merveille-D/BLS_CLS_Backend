<?php

namespace App\Http\Resources\Litigation;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LitigationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $id = $request->route('litigation');

        return [
            'id' => $this->id,
            'name' => $this->name,
            'reference' => $this->reference,
            'case_number' => $this->case_number,
            'state' => $this->state,
            'is_archived' => $this->is_archived ? true : false,
            'nature' => new LitigationSettingResource($this->nature) ?? null,
            'parties' => PartyResource::collection($this->parties),
            'jurisdiction' => new LitigationSettingResource($this->jurisdiction),
            'jurisdiction_location' => $this->jurisdiction_location ?? null,
            'estimated_amount' => $this->estimated_amount,
            'added_amount' => collect($this->added_amount)->sum('amount'),
            'added_amount_detail' => $this->added_amount,
            'remaining_amount' => $this->remaining_amount,
            'has_provisions' => $this->has_provisions,

            'next_step' => $this->when($id, new LitigationTaskResource($this->next_task)),
            'current_step' => $this->when($id, new LitigationTaskResource($this->current_task)),
            'lawyers' => $this->lawyers ?? null,
            'users' => $this->users ?? null,
            'created_at' => $this->created_at,
            'extra' => $this->extra,
            'documents' => DocumentResource::collection($this->whenLoaded('documents')),
        ];
    }
}

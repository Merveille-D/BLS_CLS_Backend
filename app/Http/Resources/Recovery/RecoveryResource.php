<?php

namespace App\Http\Resources\Recovery;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecoveryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // $id = $request->route('id');
        return [
            'id' => $this->id,
            'status' => $this->status,
            'reference' => $this->reference,
            'name' => $this->name,
            'type' => $this->type,
            'has_guarantee' => $this->has_guarantee ? true : false,

            'created_at' => $this->created_at,
            // 'next_step' => $this->when($id, new ConvHypothecStepResource($this->next_step)),
            // 'current_step' => $this->when($id, new ConvHypothecStepResource($this->current_step)),
            'documents' => DocumentResource::collection($this->whenLoaded('documents')),
        ];
    }
}

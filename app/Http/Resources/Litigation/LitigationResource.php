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
        return [
            'id' => $this->id,
            'name' => $this->name,
            'reference' => $this->reference,
            'state' => $this->state,
            'is_achirved' => $this->is_achirved,
            'nature' => $this->nature ?? null,
            'party' => $this->party ?? null,
            'jurisdiction' => $this->jurisdiction ?? null,
            'estimated_amount' => $this->estimated_amount,
            'added_amount' => $this->added_amount,
            'remaining_amount' => $this->remaining_amount,
            'lawyer' => $this->lawyer ?? null,
            'user' => $this->user ?? null,
            'created_at' => $this->created_at,
            'documents' => DocumentResource::collection($this->whenLoaded('documents')),
        ];
    }
}

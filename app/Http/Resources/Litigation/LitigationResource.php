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
        // dd($this->nature);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'reference' => $this->reference,
            'state' => $this->state,
            'is_achirved' => $this->is_achirved,
            'nature' => $this->nature->name ?? null,
            'party' => $this->party->name ?? null,
            'jurisdiction' => $this->jurisdiction->name ?? null,
            'estimated_amount' => $this->estimated_amount,
            'added_amount' => $this->added_amount,
            'remaining_amount' => $this->remaining_amount,
            'lawyer' => $this->lawyer->name ?? null,
            'created_at' => $this->created_at,
            'documents' => DocumentResource::collection($this->whenLoaded('documents')),
        ];
    }
}

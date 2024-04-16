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
        // dd((collect($this->added_amount))->sum('amount'));
        return [
            'id' => $this->id,
            'name' => $this->name,
            'reference' => $this->reference,
            'state' => $this->state,
            'is_archived' => $this->is_archived ? true : false,
            'nature' => $this->nature ?? null,
            'party' => $this->party ?? null,
            'jurisdiction' => $this->jurisdiction ?? null,
            'estimated_amount' => $this->estimated_amount,
            'added_amount' => collect($this->added_amount)->sum('amount'),
            'added_amount_detail' => $this->added_amount,
            'remaining_amount' => $this->remaining_amount,
            'lawyer' => $this->lawyer ?? null,
            'user' => $this->user ?? null,
            'created_at' => $this->created_at,
            'documents' => DocumentResource::collection($this->whenLoaded('documents')),
        ];
    }
}

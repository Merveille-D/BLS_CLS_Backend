<?php

namespace App\Http\Resources\Litigation;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PartyResource extends JsonResource
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
            'party_type' => $this->type,
            'type' => $this->pivot->type ?? null,
            'category' => $this->pivot->category ?? null,
            'phone' => $this->phone,
            'email' => $this->email,
            'created_at' => $this->created_at,
        ];
    }
}

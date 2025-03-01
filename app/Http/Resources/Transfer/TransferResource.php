<?php

namespace App\Http\Resources\Transfer;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransferResource extends JsonResource
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
            'title' => $this->title,
            'deadline' => $this->deadline,
            'description' => $this->description,
            'status' => $this->status,
            'sender_id' => $this->sender_id,
            'collaborators' => $this->collaborators,
            'sender' => $this->sender,
        ];
    }
}

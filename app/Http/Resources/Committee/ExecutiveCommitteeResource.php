<?php

namespace App\Http\Resources\Committee;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExecutiveCommitteeResource extends JsonResource
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
            'committable' => $this->committable,
            'created_at' => $this->created_at,
        ];
    }
}

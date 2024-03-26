<?php

namespace App\Http\Resources\Administrator;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdministratorResource extends JsonResource
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
            'type' => $this->type,
            'address' => $this->address,
            'nationality' => $this->nationality,
            'created_at' => $this->created_at,
            // 'representant' => $this->whenLoaded('representing', new AdministratorResource($this->representing)),
            'representant' => new AdministratorResource($this->whenLoaded('representing')),
        ];
    }
}

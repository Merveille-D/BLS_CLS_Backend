<?php

namespace App\Http\Resources\Recovery;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecoveryStepResource extends JsonResource
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
            'code' => $this->code,
            'name' => $this->name,
            'status' => $this->status ? true : false,
            'type' => $this->type,
            'deadline' => $this->deadline,
            'form' => $this->when($this->form, $this->form),
            // 'steps' => ConvHypothecStepResource::collection($this->whenLoaded('steps')),
        ];
    }
}

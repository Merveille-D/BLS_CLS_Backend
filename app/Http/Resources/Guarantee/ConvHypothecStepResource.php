<?php

namespace App\Http\Resources\Guarantee;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConvHypothecStepResource extends JsonResource
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
            'max_delay' => $this->max_delay,
            'min_delay' => $this->min_delay,
            'type' => $this->type,
            'deadline' => null
            // 'steps' => ConvHypothecStepResource::collection($this->whenLoaded('steps')),
        ];
    }
}

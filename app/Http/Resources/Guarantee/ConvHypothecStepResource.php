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
            'status' => $this->status ? true : false,
            'max_deadline' => $this->max_deadline,
            'min_deadline' => $this->min_deadline,
            'type' => $this->type,
            'deadline' => $this->deadline
            // 'steps' => ConvHypothecStepResource::collection($this->whenLoaded('steps')),
        ];
    }
}

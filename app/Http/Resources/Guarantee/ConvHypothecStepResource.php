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
            'min_deadline' => $this->min_deadline,
            'max_deadline' => $this->max_deadline,
            // 'done_at' => $this->,
            'type' => $this->type,
            // 'deadline' => $this->deadline,
            'form' => $this->when($this->form, $this->form),
            // 'steps' => ConvHypothecStepResource::collection($this->whenLoaded('steps')),
        ];
    }
}

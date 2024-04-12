<?php

namespace App\Http\Resources\Litigation;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LitigationSettingResource extends JsonResource
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
            'type' => $this->type,
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
}

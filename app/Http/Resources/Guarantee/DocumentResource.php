<?php

namespace App\Http\Resources\Guarantee;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
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
            'state' => $this->state,
            'filename' => $this->file_name,
            'file_url' => format_file_path($this->file_path),
            'created_at' => $this->created_at,
        ];
    }
}

<?php

namespace App\Http\Resources\Incident;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IncidentResource extends JsonResource
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
            'date_received' => $this->date_received,
            'type' => $this->type,
            'author_incident_id' => $this->author_incident_id,
            'user_id' => $this->user_id,
            'client' => $this->client,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'reference' => $this->reference,
            'incident_reference' => $this->incident_reference,
            'created_at' => $this->created_at,
            'category' => $this->category,
            'current_task' => $this->current_task,
            'files' => $this->files,
        ];
    }
}

<?php

namespace App\Http\Resources\Incident;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskIncidentResource extends JsonResource
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
            'title' => __('incident.' . $this->title),
            'info_channel' => $this->info_channel,
            'info_channel_value' => $this->info_channel_value,
            'date' => $this->date,
            'raised_hand' => $this->raised_hand,
            'incident_id' => $this->incident_id,
            'status' => $this->status,
            'code' => $this->code,
            'conversion_certificate' => $this->conversion_certificate,
            'deadline' => $this->deadline,
            'completed_by' => $this->completed_by,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'file_uploads' => $this->fileUploads,
            'form' => $this->form,
        ];
    }
}

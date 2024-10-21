<?php

namespace App\Http\Resources\GeneralMeeting;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskGeneralMeetingResource extends JsonResource
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
            // 'libelle' => __($this->code),
            'libelle' => $this->code ? __('governance.'. $this->code) : $this->libelle,
            'deadline' => $this->deadline,
            'type' => $this->type,
            'status' => $this->status,
            'responsible' => $this->responsible,
            'supervisor' => $this->supervisor,
            'general_meeting_id' => $this->general_meeting_id,
            'completed_by' => $this->completed_by,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
        ];
    }
}

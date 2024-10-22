<?php

namespace App\Http\Resources\ManagementCommittee;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskManagementCommitteeResource extends JsonResource
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
            'libelle' => $this->code ? __('governance.'. $this->code) : $this->libelle,
            'deadline' => $this->deadline,
            'type' => $this->type,
            'status' => $this->status,
            'responsible' => $this->responsible,
            'supervisor' => $this->supervisor,
            'management_committee_id' => $this->management_committee_id,
            'completed_by' => $this->completed_by,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
        ];
    }
}

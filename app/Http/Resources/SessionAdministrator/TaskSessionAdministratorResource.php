<?php

namespace App\Http\Resources\SessionAdministrator;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskSessionAdministratorResource extends JsonResource
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
            'session_administrator_id' => $this->session_administrator_id,
            'completed_by' => $this->completed_by,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
        ];
    }
}

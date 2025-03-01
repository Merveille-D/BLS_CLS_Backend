<?php

namespace App\Http\Resources\Alert;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            // 'state' => $this->state,
            'priority' => $this->alert?->priority,
            'sent_by' => $this->sent_by,
            'sent_to' => $this->sent_to,
            'title' => $this->data['title'],
            'message' => $this->data['message'],
            'type' => $this->type,
            'read_at' => $this->read_at,
            'data' => $this->data,
            'deadline' => $this->alert?->deadline,
            'module_id' => $this->alert->alertable->module_id ?? null,
            'task' => $this->when($this->alert, /* new AlertResource */ ($this->alert?->alertable?->validation ?? $this->alert?->alertable?->transferable->validation ?? null)),
        ];
    }
}

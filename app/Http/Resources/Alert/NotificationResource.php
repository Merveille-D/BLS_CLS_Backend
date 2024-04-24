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
            'sent_by' => $this->sent_by,
            'sent_to' => $this->sent_to,
            'title' => $this->data['title'],
            'message' => $this->data['message'],
            'type' => $this->type,
            'read_at' => $this->read_at,
            'data' => $this->data,
        ];
    }
}
<?php

namespace App\Http\Resources\Watch;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LegalWatchResource extends JsonResource
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
            'name' => $this->name,
            'case_number' => $this->case_number,
            'reference' => $this->reference,
            'type' => $this->type,
            'summary' => $this->summary,
            'innovation' => $this->innovation,
            'is_archived' => $this->is_archived,
            'event_date' => $this->event_date,
            'effective_date' => $this->effective_date,
            'nature' => $this->nature ?? null,
            'jurisdiction' => $this->jurisdiction ?? null,
            'jurisdiction_location' => $this->jurisdiction_location,
            'recipient_type' => $this->recipient_type,
            'mail_object' => $this->mail_object,
            'mail_content' => $this->mail_content,
            'mail_addresses' => $this->mail_addresses,
            'is_sent' => !$this->is_archived && $this->is_sent ? true : false,
        ];
    }
}

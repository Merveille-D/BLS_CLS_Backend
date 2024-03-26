<?php

namespace App\Http\Resources\Guarantee;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConvHypothecResource extends JsonResource
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
            'reference' => $this->reference,
            'contract_id' => $this->contract_id,
            'contract_file' => '/storage/'.$this->contract_file,
            'is_approved' => $this->is_approved,
            'is_subscribed' => $this->is_subscribed,
            'registering_date' => $this->registering_date,
            'registration_date' => $this->registration_date,
            'date_signification' => $this->date_signification,
            'date_deposit_specification' => $this->date_deposit_specification,
            'sell_price_estate' => $this->sell_price_estate,
            // 'documents' => new DocumentCollection(new DocumentResource($this->documents))
            'documents' => DocumentResource::collection($this->whenLoaded('documents')),
        ];
    }
}

<?php

namespace App\Http\Resources\Contract;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContractResource extends JsonResource
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
            'date_signature' => $this->date_signature,
            'date_effective' => $this->date_effective,
            'date_expiration' => $this->date_expiration,
            'date_renewal' => $this->date_renewal,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'contract_reference' => $this->contract_reference,
            'reference' => $this->reference,
            'created_at' => $this->created_at,
            'first_part' => $this->first_part,
            'second_part' => $this->second_part,
            'category' => $this->contractCategory,
            'type_category' => $this->contractTypeCategory,
            'sub_type_category' => $this->contractSubTypeCategory,
            'documents' => $this->documents,
            'transfers' => $this->transfers->map(function ($transfer) {
                $transfer->sender = $transfer->sender;
                $transfer->collaborators = $transfer->collaborators;

                return $transfer;
            }),
        ];

    }
}

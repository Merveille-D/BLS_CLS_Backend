<?php

namespace App\Http\Resources\Contract;

use App\Models\Contract\ContractModel;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContractModelResource extends JsonResource
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
            'type' => $this->type,
            'file_path' => $this->file_path,
            'created_at' => $this->created_at,
        ];

    }

    /**
     * Récupère le nom du modèle parent, s'il existe.
     *
     * @return string|null
     */
    private function getParentName(): ?string
    {
        return ContractModel::where('parent_id', $this->parent_id)->value('name');
    }
}

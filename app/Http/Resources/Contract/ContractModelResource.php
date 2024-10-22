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
            'name' => $this->getParentName(),
            'childrens' => $this->only(['name', 'type', 'file_path']),
            'created_at' => $this->created_at,
        ];
    }

    /**
     * Get the name of the parent contract model, if available.
     *
     * @return string|null
     */
    private function getParentName(): ?string
    {
        return $this->parent_id 
            ? ContractModel::where('parent_id', $this->parent_id)->value('name') 
            : null;
    }
}

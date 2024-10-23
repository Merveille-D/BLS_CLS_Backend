<?php
namespace App\Repositories\Contract;

use App\Http\Resources\Contract\ContractModelResource;
use App\Models\Contract\ContractModel;
use Illuminate\Support\Facades\Auth;

class ContractModelRepository
{
    public function __construct(private ContractModel $contract_model) {

    }

    public function list($request)
    {
        // Filtrer les modèles en fonction de la présence de parent_id
        $parentId = $request['parent_id'] ?? null;

        $contract_models = $this->contract_model->when(
            $parentId, 
            fn($query) => $query->where('parent_id', $parentId),
            fn($query) => $query->whereNull('parent_id')
        )->get();

        return [
            'parent' => $parentId ? new ContractModelResource($this->getParent($parentId)) : null,
            'children' => ContractModelResource::collection($contract_models),
        ];
    }

    
    private function getParent($parentId)
    {
        return $this->contract_model->where('id', $parentId)->first();
    }

    public function store($request) {

        if(isset($request['file'])) {
            $path = uploadFile($request['file'], 'contract_model_documents');
            $request['file_path'] = $path;
        }

        $request['created_by'] = Auth::user()->id;

        $contract_model = $this->contract_model->create($request);

        return $contract_model;
    }

    public function update(ContractModel $contract_model, $request) {

        $contract_model->update($request);
        return $contract_model;
    }

}

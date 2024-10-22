<?php
namespace App\Repositories\Contract;

use App\Http\Resources\Contract\ContractModelResource;
use App\Models\Contract\ContractModel;
use Illuminate\Support\Facades\Auth;

class ContractModelRepository
{
    public function __construct(private ContractModel $contract_model) {

    }

    public function list($request){

        $contract_models = ContractModel::when(
            $request->filled('parent_id'), 
            function($query) use ($request) {
                $query->where('parent_id', $request->parent_id);
            }, 
            function($query) {
                $query->whereNull('parent_id');
            }
        )->get();

        return [
            'name' => $this->getParentName(),
            'contract_models' => ContractModelResource::collection($contract_models),
        ];
    }

    private function getParentName(): ?string
    {
        return ContractModel::where('parent_id', $this->parent_id)->value('name');
    }


    /**
     * @param Request $request
     *
     * @return Part
     */
    public function store($request) {

        if(isset($request['file'])) {
            $path = uploadFile($request['file'], 'contract_model_documents');
            $request['file_path'] = $path;
        }

        $request['created_by'] = Auth::user()->id;

        $contract_model = $this->contract_model->create($request);

        return $contract_model;
    }

}

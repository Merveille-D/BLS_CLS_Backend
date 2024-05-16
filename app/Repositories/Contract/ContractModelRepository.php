<?php
namespace App\Repositories\Contract;

use App\Models\Contract\ContractModel;

class ContractModelRepository
{
    public function __construct(private ContractModel $contract_model) {

    }


    /**
     * @param Request $request
     *
     * @return Part
     */
    public function store($request) {
            
            $path = uploadFile($request['file'], 'contract_model_documents');
            $requestData = $request->except('file');
            $requestData['file'] = $path;
    
            $contract_model = $this->contract_model->create($requestData);
    
            return $contract_model;
    }

}

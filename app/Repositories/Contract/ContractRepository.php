<?php
namespace App\Repositories\Contract;

use App\Models\Contract\Contract;
use App\Models\Gourvernance\GourvernanceDocument;
use DateTime;

class ContractRepository
{
    public function __construct(private Contract $contract) {

    }

    /**
     * @param Request $request
     *
     * @return Contract
     */
    public function store($request) {

        $path = uploadFile($request['contract_file'], 'contract_documents');

        $requestData = $request->except('contract_file');
        $requestData['contract_file'] = $path;
        $contract = $this->contract->create($requestData);

        return $contract;
    }

    /**
     * @param Request $request
     *
     * @return Contract
     */
    public function update(Contract $contract, $request) {

        $contract->update($request);
        return $contract;
    }

}

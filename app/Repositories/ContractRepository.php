<?php
namespace App\Repositories;

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

        $request->merge(['contract_file' => uploadFile($request['contract_file'], 'contract_documents')]);
        $contract = $this->contract->create($request->all());

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

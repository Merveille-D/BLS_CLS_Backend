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

        $first_part = $request['first_part'];
        $second_part = $request['second_part'];

        $first_part = array_map(function ($part) {
            return [
                'description' => $part['description'],
                'type' => 'part_1',
                'part_id' => $part['part_id'],
            ];
        }, $first_part);

        $second_part = array_map(function ($part) {
            return [
                'description' => $part['description'],
                'type' => 'part_2',
                'part_id' => $part['part_id'],
            ];
        }, $second_part);

        $contract->contractParts()->createMany(array_merge($first_part, $second_part));

        return $contract;
    }

    /**
     * @param Request $request
     *
     * @return Contract
     */
    public function update(Contract $contract, $request) {

        if (isset($request['contract_file'])) {
            $path = uploadFile($request['contract_file'], 'contract_documents');
            $requestData = $request->except('contract_file');
            $requestData['contract_file'] = $path;
        } else {
            $requestData = $request;
        }

        // if(isset($request['first_part']) && isset($request['second_part'])) {

        //     $contract->contractParts()->delete();
        //     $first_part = $request['first_part'];
        //     $second_part = $request['second_part'];

        //     $first_part = array_map(function ($part) {
        //         return [
        //             'description' => $part['description'],
        //             'type' => 'part_1',
        //             'part_id' => $part['part_id'],
        //         ];
        //     }, $first_part);

        //     $second_part = array_map(function ($part) {
        //         return [
        //             'description' => $part['description'],
        //             'type' => 'part_2',
        //             'part_id' => $part['part_id'],
        //         ];
        //     }, $second_part);
        // }

        $contract->contractParts()->createMany(array_merge($first_part, $second_part));

        $contract->update($requestData);

        return $contract;
    }

}

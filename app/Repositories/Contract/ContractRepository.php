<?php
namespace App\Repositories\Contract;

use App\Models\Contract\Contract;
use App\Concerns\Traits\Transfer\AddTransferTrait;
use App\Models\Contract\ContractDocument;
use Illuminate\Support\Facades\Auth;

class ContractRepository
{
    use AddTransferTrait;

    public function __construct(private Contract $contract) {

    }

    /**
     * @param Request $request
     *
     * @return Contract
     */
    public function store($request) {

        $request = $request->all();
        $request['created_by'] = Auth::user()->id;
        $request['reference'] = generateReference('CONTRACT', $this->contract);


        $contract = $this->contract->create($request);

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

        foreach($request['contract_documents'] as $item) {

            $fileUpload = new ContractDocument();

            $fileUpload->name = $item['name'];
            $fileUpload->file = uploadFile($item['file'], 'contract_documents');

            $contract->fileUploads()->save($fileUpload);
        }

        return $contract;
    }

    /**
     * @param Request $request
     *
     * @return Contract
     */
    public function update(Contract $contract, $request) {

        if (isset($request['contract_documents'])) {

            $contract->fileUploads()->delete();

            foreach($request['contract_documents'] as $item) {

                $fileUpload = new ContractDocument();

                $fileUpload->name = $item['name'];
                $fileUpload->file = uploadFile($item['file'], 'contract_documents');

                $contract->fileUploads()->save($fileUpload);
            }
        }

        if(isset($request['first_part']) && isset($request['second_part'])) {

            $contract->contractParts()->delete();

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
        }

        $contract->update($request);

        if(isset($request['forward_title'])) {
            $this->add_transfer($contract, $request['forward_title'], $request['deadline_transfer'], $request['description'], $request['collaborators']);
        }

        return $contract;
    }
}

<?php
namespace App\Repositories\Contract;

use App\Models\Contract\Contract;
use App\Models\Contract\ContractDocument;
use App\Models\Contract\Task;
use App\Models\Gourvernance\GourvernanceDocument;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;

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

        $contract = $this->contract->create($request->all());

        $first_part = $request['first_part'];
        $second_part = $request['second_part'];

        $first_part = array_map(function ($part) {
            return [
                'description' => $part['description'],
                'type' => 'part_1',
                'part_id' => $part['part_id'],
            ];
        }, $first_part);
git 
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

        // $this->createTasks($contract);

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

        return $contract;
    }


    public function createTasks($contract) {

        $tasks = Task::MILESTONES;

        foreach($tasks as $task) {

            $task = array_merge($task, [
                'contract_id' => $contract->id,
                'created_by' => Auth::user()->id,
                'deadline' => Carbon::now()->addDays($task['days']),
            ]);

            // dd($task);

            Task::create($task);
        }

        return $task;
    }
}

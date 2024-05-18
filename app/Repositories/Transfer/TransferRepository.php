<?php
namespace App\Repositories\Transfer;

use App\Http\Resources\Transfer\TransferResource;
use App\Models\Audit\AuditNotation;
use App\Models\Transfer\Transfer;
use App\Models\Transfer\TransferDocument;
use App\Repositories\Audit\AuditNotationRepository;
use App\Repositories\Evaluation\NotationRepository;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TransferRepository
{
    public function __construct(
        private Transfer $transfer,
        public AuditNotationRepository $audit,
        public NotationRepository $evaluation
    ) {
    }


    public function getList() : ResourceCollection {
        $query = $this->transfer->paginate();

        return TransferResource::collection($query);
    }


    public function show($transfer) {
        return new TransferResource($transfer);
    }

    public function add($request) {
        $transfer = Transfer::create([
            'title' => $request['title'],
            'deadline' => $request['deadline'],
            'description' => $request['description'],
            'completed_user' => $request['completed_user'],
        ]);

        $transfer->collaborators()->attach($request['collaborators']);

        return new TransferResource($transfer);
    }

    public function update($request, $transfer) {
        $transfer->update([
            'title' => $request['title'],
            'deadline' => $request['deadline'],
            'description' => $request['description'],
            'status' => $request['status'],
        ]);

        $transfer->collaborators()->sync($request['collaborators']);

        return new TransferResource($transfer);
    }

    public function delete($transfer) {
        $transfer->delete();
    }

    public function completeTransfer($request, $transfer) {

        $model = $transfer->transferable;

        if($request['type'] === 'audit') {
            $this->audit->store($request);
        }

        if($request['type'] === 'evaluation') {
            $this->evaluation->store($request);
        }

        if($request['type'] === 'contract') {
            foreach($request['contract_documents'] as $item) {
                $fileUpload = new TransferDocument();

                $fileUpload->name = $item['name'];
                $fileUpload->file = uploadFile($item['file'], 'transfert_documents');

                $transfer->fileTransfers()->save($fileUpload);
            }
        }

        $model->update([
            'status' => $transfer->title,
        ]);

        $transfer->update([
            'status' => true,
        ]);

        return new TransferResource($transfer);
    }

}

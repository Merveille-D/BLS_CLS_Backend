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
            $request['audit_notation_id'] = $transfer->audit->first()->audit_id;
            $this->audit->completeTransfer($request);
        }

        if($request['type'] === 'evaluation') {
            $request['notation_id'] = $transfer->evaluation->first()->evaluation_id;
            $this->evaluation->completeTransfer($request);
        }

        if($request['type'] === 'contract') {
            foreach($request['contract_documents'] as $item) {
                $fileUpload = new TransferDocument();

                $fileUpload->name = $item['name'];
                $fileUpload->file = uploadFile($item['file'], 'transfert_documents');

                $transfer->fileTransfers()->save($fileUpload);
            }

            $transfer->transferable->update([
                'status' => $transfer->title,
            ]);
        }

        if($request['type'] === 'guarantee') {
            foreach($request['documents'] as $item) {
                $fileUpload = new TransferDocument();

                $fileUpload->name = $item['name'];
                $fileUpload->file = uploadFile($item['file'], 'guarantee/transfer');

                $transfer->fileTransfers()->save($fileUpload);
            }

            // $transfer->transferable->update([
            //     'status' => $transfer->title,
            // ]);
        }

        $transfer->update([
            'status' => true,
        ]);

        return new TransferResource($transfer);
    }

}

<?php
namespace App\Repositories\Transfer;

use App\Http\Resources\Transfer\TransferResource;
use App\Models\Transfer\Transfer;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TransferRepository
{
    public function __construct(
        private Transfer $transfer
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

}

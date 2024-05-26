<?php

namespace App\Concerns\Traits\Transfer;

use App\Models\Transfer\Transfer;
use Carbon\Carbon;
use DateInterval;
use DateTime;
use DateTimeImmutable;
use Illuminate\Database\Eloquent\Model;

trait AddTransferTrait
{

    /**
     * add_transfer
     *
     * @param  mixed $model
     * @param  mixed $title
     * @param  mixed $deadline
     * @param  mixed $description
     * @param  mixed $collaborators
     * @return void
     */
    public function add_transfer(Model $model, string $title, $deadline, $description = "", $collaborators)
    {
        $transfer = new Transfer();
        $transfer->title = $title;
        $transfer->description = $description ?? null;
        $transfer->deadline = Carbon::parse($deadline);
        $transfer->sender_id = auth()->id();
        $model->transfers()->save($transfer);

        $transfer->collaborators()->sync($collaborators);

        return $transfer;
    }

    public function update_transfer(Model $model, $collaborators) {
        // $transfer = $model->transfers->first();

        // $existing_collaborators = $transfer->collaborators;
        // $new_collaborators = array_diff($collaborators, $existing_collaborators->pluck('id')->toArray());
        // $transfer->collaborators()->attach($new_collaborators);

        // $removed_collaborators = array_diff($existing_collaborators->pluck('id')->toArray(), $collaborators);
        // $transfer->collaborators()->detach($removed_collaborators);

        // dd($transfer->collaborators);

        // $transfer->collaborators()->sync($collaborators);
    }
}

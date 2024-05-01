<?php

namespace App\Concerns\Traits\Transfer;

use App\Models\Transfer\Transfer;
<<<<<<< HEAD
use Carbon\Carbon;
=======
use DateInterval;
use DateTime;
use DateTimeImmutable;
>>>>>>> a6e3f6acdcd086cebfb7e70d8a1e4b5168e9b49a
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
<<<<<<< HEAD
    public function add_transfer(Model $model, string $title, $deadline, $description = null, $collaborators) : void {
=======
    public function add_transfer(Model $model, string $title, $deadline, $description = null, $collaborators): void
    {
        $dates = $this->getMilestoneDates($deadline);
>>>>>>> a6e3f6acdcd086cebfb7e70d8a1e4b5168e9b49a

        $transfer = new Transfer();
        $transfer->title = $title;
        $transfer->description = $description ?? null;
        $transfer->deadline = Carbon::parse($deadline);
        $model->transfers()->save($transfer);

        $transfer->collaborators()->sync($collaborators);
    }

    public function update_transfer(Model $model, $collaborators) {
        $transfer = $model->transfers;
        dd($transfer);

        $transfer->collaborators()->sync($collaborators);

    }
}

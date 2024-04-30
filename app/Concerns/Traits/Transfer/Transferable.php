<?php
namespace App\Concerns\Traits\Transfer;

use App\Models\Transfer\Transfer;

trait Transferable
{
    /**
     * documents relationship
     *
     * @return MorphMany
     */
    public function transfers()
    {
        return $this->morphMany(Transfer::class, 'transferable');
    }
}

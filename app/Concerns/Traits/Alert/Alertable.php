<?php
namespace App\Concerns\Traits\Alert;

use App\Models\Alert\Alert;

trait Alertable
{
    /**
     * documents relationship
     *
     * @return MorphMany
     */
    public function alerts()
    {
        return $this->morphMany(Alert::class, 'alertable');
    }
}

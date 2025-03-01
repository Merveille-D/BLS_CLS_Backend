<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class CountryScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {

        if (Auth::check()) {
            $user = Auth::user();
            //if user super admin, he can see all data
            if ($user->hasRole('super_admin')) {
                return;
            }
            //Otherwise, filter based on the subsidiary_id of the creator
            $subsidiaryId = $user->subsidiary_id;
            $builder->whereHas('creator', function (Builder $query) use ($subsidiaryId) {
                $query->where('subsidiary_id', $subsidiaryId);
            });
        }
    }
}

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
        dd(Auth::user());
        if (Auth::check()) {
            $countryId = Auth::user()->country_id;
            $builder->whereHas('creator', function (Builder $query) use ($countryId) {
                $query->where('country_id', $countryId);
            });
        }
    }
}

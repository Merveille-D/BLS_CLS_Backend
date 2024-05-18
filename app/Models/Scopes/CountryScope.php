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
            $countryId = Auth::user()->country_id;
            $currentTable = $model->getTable();
            $builder->join('users', 'users.id', '=', $currentTable.'.created_by')
                    ->where('country_id', $countryId)
                    ->select($currentTable . '.*');
        }
    }
}

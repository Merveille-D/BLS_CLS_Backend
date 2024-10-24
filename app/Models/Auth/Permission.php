<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as ModelsPermission;

class Permission extends ModelsPermission
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'label',
        'description',
        'permission_entity_id',
        'guard_name',
    ];
}

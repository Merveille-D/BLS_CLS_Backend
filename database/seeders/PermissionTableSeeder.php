<?php

namespace Database\Seeders;

use App\Models\Auth\Permission;
use App\Models\Auth\PermissionEntity;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $models = [
            'Subsidiary',
            'Role',
            'User',
        ];

        foreach ($models as $model) {
            Artisan::call('make:policy ' . $model . 'Policy --model=' . $model);
        }

        $models_translate = [
            'Role' => 'Rôle',
            'Subsidiary' => 'Filiale',
            'User' => 'Utilisateur',
        ];

        foreach ($models as $model) {
            $permissionEntity = PermissionEntity::where('name', $model)->first();
            $permissionEntity = $permissionEntity ? $permissionEntity : PermissionEntity::create([
                'name' => $model,
                'description' => $models_translate[$model],
            ]);

            $permissions = [
                [
                    'name' => 'create_' . Str::snake($model),
                    'label' => 'Ajouter',
                    'description' => 'Ajouter ' . $models_translate[$model],
                    'permission_entity_id' => $permissionEntity->id,
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'view_any_' . Str::snake($model),
                    'label' => 'Consulter liste',
                    'description' => 'Consulter liste ' . $models_translate[$model],
                    'permission_entity_id' => $permissionEntity->id,
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'view_' . Str::snake($model),
                    'label' => 'Consulter détail',
                    'description' => 'Consulter détail ' . $models_translate[$model],
                    'permission_entity_id' => $permissionEntity->id,
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'edit_' . Str::snake($model),
                    'label' => 'Modifier',
                    'description' => 'Modifier ' . $models_translate[$model],
                    'permission_entity_id' => $permissionEntity->id,
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'delete_' . Str::snake($model),
                    'label' => 'Supprimer',
                    'description' => 'Supprimer ' . $models_translate[$model],
                    'permission_entity_id' => $permissionEntity->id,
                    'guard_name' => 'web',
                ],
            ];

            // Permission::createMany($permissions);
            foreach ($permissions as $permission) {
                Permission::create($permission);
            }
        }
        /* Permissions extra */

        Artisan::call('cache:clear');
    }
}

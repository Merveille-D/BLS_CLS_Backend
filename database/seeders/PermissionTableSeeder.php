<?php

namespace Database\Seeders;

use App\Models\Auth\Permission;
use App\Models\Auth\PermissionEntity;
use App\Models\Auth\Role;
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
            'Data',
            'Subsidiary',
            'Role',
            'User',
            'Governance',
            'Guarantee',
            'Contract',
            'Litigation',
            'Recovery',
            'Audit',
            'Evaluation',
            'Legal watch',
            'Document',
            'Incident',
        ];

        // foreach ($models as $model) {
        //     Artisan::call('make:policy ' . $model . 'Policy --model=' . $model);
        // }

        $models_translate = [
            'Data' => 'Toutes les filiales',
            'Role' => 'Rôle',
            'Subsidiary' => 'Filiale',
            'User' => 'Utilisateur',
            'Governance' => 'Gouvernance',
            'Guarantee' => 'Sureté',
            'Contract' => 'Contrat',
            'Litigation' => 'Contentieux',
            'Recovery' => 'Recouvrement',
            'Audit' => 'Audit',
            'Evaluation' => 'Evaluation',
            'Legal watch' => 'Veille juridique',
            'Document' => 'Document',
            'Incident' => 'Incident',
        ];

        foreach ($models as $model) {
            $permissionEntity = PermissionEntity::where('name', $model)->first();
            $permissionEntity = $permissionEntity ? $permissionEntity : PermissionEntity::create([
                'name' => $model,
                'description' => $models_translate[$model],
            ]);

            $permissions = $permissionEntity->name == 'Data' ?
            [
                [
                    'name' => 'view_all_' . Str::snake($model),
                    'label' => 'Consulter',
                    'description' => 'Consulter données de ' . $models_translate[$model],
                    'permission_entity_id' => $permissionEntity->id,
                    'guard_name' => 'web',
                ],
            ]
            : [
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
                if (!Permission::where('name', $permission['name'])->exists())
                    Permission::create($permission);
            }
        }
        /* Permissions extra */

        Artisan::call('cache:clear');

        /**
         * create default roles super admin, admin, manager, collaborator, legal director
         */
        $roles = [
            'super_admin' => 'Super Administrateur',
            'admin' => 'Administrateur',
            'manager' => 'Manager',
            'collaborator' => 'Collaborateur',
            'legal_director' => 'Directeur Juridique',
        ];

        foreach ($roles as $role => $label) {
            if (!Role::where('name', $role)->exists()) {
                $role = Role::create(['name' => $role, 'guard_name' => 'web']);
            }
        }

    }
}

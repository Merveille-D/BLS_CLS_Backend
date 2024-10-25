<?php

namespace Database\Seeders;

use App\Models\Auth\Permission;
use App\Models\Auth\Role;
use App\Models\Auth\Subsidiary;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //create permissions
        $role = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);

        foreach ($this->usersList() as $user) {
            $user = User::create($user);
            $user->assignRole($role);

            $user->givePermissionTo(Permission::all());
        }
    }

    public function usersList()
    {
        $country = Subsidiary::create(['name' => 'Ecobank du Togo', 'country' => 'Togo', 'address' => 'Lomé']);

        return [
            [
                'firstname' => 'AfrikSkills',
                'lastname' => '',
                'username' => 'afrikskills',
                'email' => 'afrikskills@yopmail.com',
                'password' => Hash::make('afrikskills'),
                'subsidiary_id' => $country->id,
            ],
            [
                'firstname' => 'Estelle',
                'lastname' => 'Adjaho',
                'username' => 'estelleadjaho',
                'email' => 'estelleadjaho@gmail.com',
                'password' => Hash::make('afrikskills'),
                'subsidiary_id' => $country->id,
            ],
            // array(
            //     'firstname' => 'Darlène',
            //     'lastname' => 'Gbaguidi',
            //     'email' => 'darlenegbaguidi@gmail.com',
            //     'password' => Hash::make('password')
            // ),
        ];

    }

    public function defaultPermissions(): array
    {
        return [
            // 'manage_user',
            // 'manage_local_user',
            // 'view_all_subsidiary',
            // 'view_local_subsidiary',
            // 'manage_subsidiary',
            // 'manage_roles',
            // 'manage_permissions',
            // 'manage_settings',
        ];
    }
}

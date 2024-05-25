<?php

namespace Database\Seeders;

use App\Models\Auth\Country;
use App\Models\Auth\Permission;
use App\Models\Auth\Role;
use App\Models\Auth\Subsidiary;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        foreach ($this->defaultPermissions() as $key => $permission) {
            if (!Permission::where('name', $permission)->exists()) {
                Permission::create(['name' => $permission]);
            }
        }
        if (!Role::where('name', 'super_admin')->exists()) {
            $role = Role::create(['name' => 'super_admin']);
            //attach permission
            $role->givePermissionTo(Permission::all());
        }


        foreach ($this->users_list() as $user) {
            $user = User::create($user);
            $user->assignRole($role);
        }
    }

    public function users_list() {
        $country = Subsidiary::create(['name' => 'Ecobank du Togo', 'country' => 'Togo', 'address' => 'Lomé']);

        return array(
            array(
                'firstname' => 'AfrikSkills',
                'lastname' => '',
                'username' => 'afrikskills',
                'email' => 'afrikskills@yopmail.com',
                'password' => Hash::make('password'),
                'subsidiary_id' => $country->id,
            ),
            array(
                'firstname' => 'Estelle',
                'lastname' => 'Adjaho',
                'username' => 'estelleadjaho',
                'email' => 'estelleadjaho@gmail.com',
                'password' => Hash::make('password'),
                'subsidiary_id' => $country->id,
            ),
            // array(
            //     'firstname' => 'Darlène',
            //     'lastname' => 'Gbaguidi',
            //     'email' => 'darlenegbaguidi@gmail.com',
            //     'password' => Hash::make('password')
            // ),
        );

    }

    public function defaultPermissions() : array {
        return [
            'manage_user',
            'manage_local_user',
            'view_all_subsidiary',
            'view_local_subsidiary',
            'manage_subsidiary',
            'manage_roles',
            // 'manage_permissions',
            // 'manage_settings',
        ];
    }
}

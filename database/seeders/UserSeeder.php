<?php

namespace Database\Seeders;

use App\Models\Auth\Country;
use App\Models\Auth\Role;
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
        $role = Role::create(['name' => 'super_admin']);
        foreach ($this->users_list() as $user) {
            $user = User::create($user);
            $user->assignRole($role);
        }
    }

    public function users_list() {
        $country = Country::create(['name' => 'Togo', 'code' => 'togo']);

        return array(
            array(
                'firstname' => 'AfrikSkills',
                'lastname' => '',
                'username' => 'afrikskills',
                'email' => 'afrikskills@yopmail.com',
                'password' => Hash::make('password'),
                'country_id' => $country->id,
            ),
            // array(
            //     'firstname' => 'Estelle',
            //     'lastname' => 'Adjaho',
            //     'email' => 'estelleadjaho@gmail.com',
            //     'password' => Hash::make('password')
            // ),
            // array(
            //     'firstname' => 'Darlène',
            //     'lastname' => 'Gbaguidi',
            //     'email' => 'darlenegbaguidi@gmail.com',
            //     'password' => Hash::make('password')
            // ),
        );

    }
}

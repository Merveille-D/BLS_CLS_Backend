<?php

namespace Database\Seeders;

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
        foreach ($this->users_list() as $user) {
            User::create($user);
        }
    }

    public function users_list() {
        return array(
            array(
                'firstname' => 'AfrikSkills',
                'lastname' => '',
                'email' => 'afrikskills@yopmail.com',
                'password' => Hash::make('password')
            ),
            array(
                'firstname' => 'Estelle',
                'lastname' => 'Adjaho',
                'email' => 'estelleadjaho@gmail.com',
                'password' => Hash::make('password')
            ),
            // array(
            //     'firstname' => 'Darlène',
            //     'lastname' => 'Gbaguidi',
            //     'email' => 'darlenegbaguidi@gmail.com',
            //     'password' => Hash::make('password')
            // ),
        );

    }
}

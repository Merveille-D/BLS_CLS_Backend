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
        $existingUser = User::where('email', 'test@example.com')->first();

        if (!$existingUser) {
            $user = User::create([
                'name' => 'Test Utilisateur',
                'email' => 'raoulgbadou@gmail.com',
                'password' => Hash::make('password')
            ]);
        }
    }
}

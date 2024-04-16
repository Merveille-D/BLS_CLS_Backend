<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Database\Seeders\Guarantee\ConvHypothecSeeder;
use Database\Seeders\Litigation\LawyerSeeder;
use Database\Seeders\Litigation\LitigationResourceSeeder;
use Database\Seeders\Litigation\LitigationSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // $this->call(UserSeeder::class);
        // $this->call(LitigationResourceSeeder::class); //containing test data
        $this->call(ConvHypothecSeeder::class);
        // $this->call(LitigationSeeder::class); //for test
        // $this->call(LawyerSeeder::class); //for test
    }
}

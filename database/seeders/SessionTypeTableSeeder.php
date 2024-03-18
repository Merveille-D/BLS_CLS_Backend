<?php

namespace Database\Seeders;

use App\Models\Gourvernance\BoardDirectors\Sessions\SessionType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SessionTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SessionType::create([
            'name'  => 'Préparer AG',
            'code' => 'PA',
        ]);

        SessionType::create([
            'name'  => 'Tenir AG',
            'code' => '',
        ]);

        SessionType::create([
            'name'  => 'Execution Post AG',
            'code' => 'EPA',
        ]);
    }
}

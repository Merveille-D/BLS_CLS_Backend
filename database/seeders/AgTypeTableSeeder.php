<?php

namespace Database\Seeders;

use App\Models\Gourvernance\GeneralMeeting\AgType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AgTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AgType::create([
            'name'  => 'Préparer AG',
            'code' => 'PA',
        ]);

        AgType::create([
            'name'  => 'Tenir AG',
            'code' => '',
        ]);

        AgType::create([
            'name'  => 'Execution Post AG',
            'code' => 'EPA',
        ]);
    }
}

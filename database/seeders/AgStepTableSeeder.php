<?php

namespace Database\Seeders;

use App\Models\Gourvernance\GeneralMeeting\AgStep;
use App\Models\Gourvernance\GeneralMeeting\AgType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AgStepTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $steps = [
            'Préparer AG' => [
                'file 1',
                'file 2',
                'file 3',
            ],
            'Tenir AG' => [
                'file 4',
                'file 5',
                'file 6',
            ],
            'Execution Post AG' => [
                'file 7',
                'file 8',
                'file 9',
            ]
        ];

        foreach ($steps as $step => $files) {
            $ag_step = AgStep::create(['name' => $step]);
            foreach ($files as $file) {
                $ag_step->type_files()->create(['name' => $file]);
            }
        }
    }
}

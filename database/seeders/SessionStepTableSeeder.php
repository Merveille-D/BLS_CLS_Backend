<?php

namespace Database\Seeders;

use App\Models\Gourvernance\BoardDirectors\Sessions\SessionStep;
use App\Models\Gourvernance\GeneralMeeting\AgStep;
use App\Models\Gourvernance\GeneralMeeting\AgType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SessionStepTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $steps = [
            'Préparer CA' => [
                'file 1',
                'file 2',
                'file 3',
            ],
            'Tenir CA' => [
                'file 4',
                'file 5',
                'file 6',
            ],
            'Execution Post CA' => [
                'file 7',
                'file 8',
                'file 9',
            ]
        ];

        foreach ($steps as $step => $files) {
            $session_step = SessionStep::create(['name' => $step]);
            foreach ($files as $file) {
                $session_step->type_files()->create(['name' => $file]);
            }
        }
    }
}

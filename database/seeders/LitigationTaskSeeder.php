<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LitigationTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tasks = $this->tasks();
        foreach ($tasks as $litigationTask) {
            \App\Models\Litigation\LitigationTask::create($litigationTask);
        }
    }

    public function tasks() : array {
        return [
            [
                'status' => true,
                'code' => 'LIT-001',
                'rank' => 1,
                'name' => 'Task 1',
                'type' => 'type 1',
                'litigation_id' => '1',
                'created_by' => '1',
                'min_deadline' => '2024-05-02',
                'max_deadline' => '2024-05-02',
            ],
            [
                'status' => true,
                'code' => 'LIT-002',
                'rank' => 2,
                'name' => 'Task 2',
                'type' => 'type 2',
                'litigation_id' => '1',
                'created_by' => '1',
                'min_deadline' => '2024-05-02',
                'max_deadline' => '2024-05-02',
            ],
            [
                'status' => true,
                'code' => 'LIT-003',
                'rank' => 3,
                'name' => 'Task 3',
                'type' => 'type 3',
                'litigation_id' => '1',
                'created_by' => '1',
                'min_deadline' => '2024-05-02',
                'max_deadline' => '2024-05-02',
            ],
        ];
    }
}

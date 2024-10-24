<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Database\Seeders\Audit\AuditPerformanceIndicatorSeeder;
use Database\Seeders\Contract\CategorySeeder;
use Database\Seeders\Contract\PartSeeder;
use Database\Seeders\Evaluation\EvaluationPerformanceIndicatorSeeder;
use Database\Seeders\Guarantee\ConvHypothecSeeder;
use Database\Seeders\Guarantee\GuaranteeSeeder;
use Database\Seeders\Incident\AuthorSeeder;
use Database\Seeders\Litigation\LawyerSeeder;
use Database\Seeders\Litigation\LitigationResourceSeeder;
use Database\Seeders\Recovery\RecoveryResourceSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(LitigationResourceSeeder::class); //containing test data
        $this->call(ConvHypothecSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(LawyerSeeder::class);
        $this->call(PartSeeder::class);
        $this->call(AuthorSeeder::class);

        $this->call(RecoveryResourceSeeder::class);
        $this->call(GuaranteeSeeder::class);

        $this->call(CategorySeeder::class);

        $this->call(AuditPerformanceIndicatorSeeder::class);
        $this->call(EvaluationPerformanceIndicatorSeeder::class);
    }
}

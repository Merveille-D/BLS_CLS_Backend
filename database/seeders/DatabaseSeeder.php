<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Database\Seeders\Audit\AuditPerformanceIndicatorSeeder;
use Database\Seeders\Guarantee\ConvHypothecSeeder;
use Database\Seeders\Incident\AuthorSeeder;
use Database\Seeders\Litigation\LawyerSeeder;
use Database\Seeders\Litigation\LitigationResourceSeeder;
use Database\Seeders\Litigation\LitigationSeeder;
use Database\Seeders\Contract\PartSeeder;
use Database\Seeders\Guarantee\GuaranteeSeeder;
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
        $this->call(LawyerSeeder::class); //for test
        $this->call(PartSeeder::class); //for test
        $this->call(AuthorSeeder::class); //for test

        $this->call(RecoveryResourceSeeder::class);
        $this->call(GuaranteeSeeder::class);

        $this->call(AuditPerformanceIndicatorSeeder::class);
    }
}

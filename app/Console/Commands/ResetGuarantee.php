<?php

namespace App\Console\Commands;

use App\Concerns\Traits\Guarantee\CollateralDefaultSteps;
use App\Concerns\Traits\Guarantee\DefaultGuaranteeTaskTrait;
use App\Concerns\Traits\Guarantee\MortgageDefaultStepTrait;
use App\Enums\Guarantee\GuaranteeType;
use App\Models\Guarantee\Guarantee;
use App\Models\Guarantee\GuaranteeStep;
use Database\Seeders\Guarantee\GuaranteeSeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ResetGuarantee extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'guarantee:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $old_steps = GuaranteeStep::query()->delete();
        $olg_guarantees = Guarantee::query()->delete();


        $step = new GuaranteeSeeder();
        $step->run();

        $this->info('All guarantees steps reset! ');
    }
}

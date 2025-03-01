<?php

namespace Database\Seeders\Recovery;

use App\Enums\Recovery\RecoveryStepEnum;
use App\Models\Recovery\RecoveryStep;
use App\Repositories\Recovery\RecoveryRepository;
use Illuminate\Database\Seeder;

class RecoveryResourceSeeder extends Seeder
{
    public function __construct(private RecoveryRepository $recoveryRepository) {}

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $steps = $this->getSteps();

        foreach ($steps as $step) {
            RecoveryStep::create($step);
        }
    }

    public function getSteps(): array
    {
        return [
            [
                'title' => 'Initiation of friendly recovery',
                'code' => RecoveryStepEnum::CREATED,
                'type' => 'friendly',
                'rank' => 1,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            [
                'title' => 'Formalization of the act (Deposit of the act in the minutes of a notary or homologation)',
                'code' => RecoveryStepEnum::FORMALIZATION,
                'type' => 'friendly',
                'rank' => 2,
                'min_delay' => null,
                'max_delay' => 10,
            ],

            //forced with guarantee
            [
                'title' => 'Initiation of forced recovery',
                'code' => RecoveryStepEnum::CREATED,
                'type' => 'forced',
                'rank' => 1,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            [
                'title' => 'Formal notice to pay addressed to the debtor client',
                'code' => RecoveryStepEnum::FORMAL_NOTICE,
                'type' => 'forced',
                'rank' => 2,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            [
                'title' => 'The debtor pays his debt',
                'code' => RecoveryStepEnum::DEBT_PAYEMENT,
                'type' => 'forced',
                'rank' => 3,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            [
                'title' => "Initiate a procedure for the seizure of the debtor's property",
                'code' => RecoveryStepEnum::SEIZURE,
                'type' => 'forced',
                'rank' => 4,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            [
                'title' => 'Obtain an enforceable title',
                'code' => RecoveryStepEnum::EXECUTORY,
                'type' => 'forced',
                'rank' => 5,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            [
                'title' => 'Seizure of the competent jurisdiction',
                'code' => RecoveryStepEnum::JURISDICTION,
                'type' => 'forced',
                'rank' => 6,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            [
                'title' => 'Entrust the procedure to a lawyer',
                'code' => RecoveryStepEnum::ENTRUST_LAWYER,
                'type' => 'forced',
                'rank' => 7,
                'min_delay' => null,
                'max_delay' => 10,
            ],
        ];
    }
}

<?php

namespace Database\Seeders\Recovery;

use App\Enums\ConvHypothecState;
use App\Enums\Recovery\RecoveryStepEnum;
use App\Models\Guarantee\ConvHypothec;
use App\Models\Guarantee\ConvHypothecStep;
use App\Models\Recovery\Recovery;
use App\Models\Recovery\RecoveryStep;
use App\Repositories\Recovery\RecoveryRepository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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

        //for test
        $recovery = DB::table('recoveries')->insert([
            'id' => 'aaa726d8-32c0-4b96-afcd-300d051cf9f0', // '9bce26d8-32c0-4b96-afcd-300d051cf9f0' is a UUID
            'name' => 'Test Recouvrement',
            'type' => 'forced',
            'reference' => 'REC-1234',
            'status' => RecoveryStepEnum::CREATED,
            'has_guarantee' => true,
            'guarantee_id' => '9bce26d8-32c0-4b96-afcd-300d051cf9f0',
        ]);

        $recovery = Recovery::find('aaa726d8-32c0-4b96-afcd-300d051cf9f0');

        $this->recoveryRepository->generateSteps($recovery);

        $this->recoveryRepository->updatePivotState($recovery);
    }

    function getSteps() : array {
        return [
            [
                'name' => 'Initiation du recouvrement amical',
                'code' => RecoveryStepEnum::CREATED,
                'type' => 'friendly',
                'rank' => 1,
            ],
            [
                'name' => "Formalisation de l'acte (Dépôt de l'acte au rang des minutes d'un notaire ou homologatuion)",
                'code' => RecoveryStepEnum::FORMALIZATION,
                'type' => 'friendly',
                'rank' => 2,
            ],

            //forced with guarantee
            [
                'name' => 'Initialisation du recouvrement forcé',
                'code' => RecoveryStepEnum::CREATED,
                'type' => 'forced',
                'rank' => 1,
            ],
            [
                'name' => "Mise en demeure de payer adressée au client débiteur",
                'code' => RecoveryStepEnum::FORMAL_NOTICE,
                'type' => 'forced',
                'rank' => 2,
            ],
            [
                'name' => "le débiteur paie sa dette",
                'code' => RecoveryStepEnum::DEBT_PAYEMENT,
                'type' => 'forced',
                'rank' => 3
            ],
            [
                'name' => "Initier une procédure de saisie des biens du débiteur",
                'code' => RecoveryStepEnum::SEIZURE,
                'type' => 'forced',
                'rank' => 4
            ],
            [
                'name' => "Obtenir un titre exécutoire",
                'code' => RecoveryStepEnum::EXECUTORY,
                'type' => 'forced',
                'rank' => 5
            ],
            [
                'name' => "Saisie de la juridiction compétente",
                'code' => RecoveryStepEnum::JURISDICTION,
                'type' => 'forced',
                'rank' => 6
            ],
            [
                'name' => "Confier la procédure à un avocat",
                'code' => RecoveryStepEnum::ENTRUST_LAWYER,
                'type' => 'forced',
                'rank' => 7
            ]
        ];
    }
}

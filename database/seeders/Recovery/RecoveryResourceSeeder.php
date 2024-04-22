<?php

namespace Database\Seeders\Recovery;

use App\Enums\ConvHypothecState;
use App\Enums\Recovery\RecoveryStepEnum;
use App\Models\Guarantee\ConvHypothec;
use App\Models\Guarantee\ConvHypothecStep;
use App\Models\Recovery\Recovery;
use App\Models\Recovery\RecoveryStep;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecoveryResourceSeeder extends Seeder
{
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
            'status' => ConvHypothecState::CREATED,
            'has_guarantee' => false,
        ]);

        $recovery = Recovery::find('aaa726d8-32c0-4b96-afcd-300d051cf9f0');
        $all_steps = RecoveryStep::orderBy('rank')
            ->when($recovery->has_guarantee == false, function ($query) use ($recovery){
                return $query->whereType($recovery->type);
            }, function($query) {
                return $query->whereType('unknown');
            })
            ->get();
        $recovery->steps()->syncWithoutDetaching($all_steps);
        $this->updatePivotState($recovery);
    }

    public function updatePivotState($recovery) {
        $currentStep = $recovery->next_step; //because the current step is not  updated yet
        if ($currentStep) {
            $pivotValues = [
                $currentStep->id => [
                    'status' => true,
                ]
            ];
            $recovery->steps()->syncWithoutDetaching($pivotValues);
        }
    }



    function getSteps() : array {
        return [
            [
                'name' => 'Initialisation du recouvrement amical',
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

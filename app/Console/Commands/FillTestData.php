<?php

namespace App\Console\Commands;

use App\Enums\ConvHypothecState;
use App\Models\Guarantee\ConvHypothec;
use App\Models\Guarantee\ConvHypothecStep;
use App\Models\Litigation\Litigation;
use App\Models\Litigation\LitigationParty;
use App\Models\Litigation\LitigationSetting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FillTestData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:test';

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
        $litigation = DB::table('litigations')->insert([
            'id' => '9bce26d8-32c0-4b96-afcd-300d051cf9f0', // '9bce26d8-32c0-4b96-afcd-300d051cf9f0' is a UUID
            'name' => 'Test init. litigation',
            'reference' => 'LIT-1234',
            'nature_id' => LitigationSetting::whereType('nature')->first()->id,
            // 'party_id' => LitigationParty::first()->id,
            'jurisdiction_id' => LitigationSetting::whereType('jurisdiction')->first()->id,
            'jurisdiction_location' => 'Lagos',
        ]);
        $litigation = Litigation::first();
        $party = LitigationParty::first();
        $party->litigations()->attach($litigation, ['category' => 'intervenant', 'type' => 'client']);

        $hypothec = DB::table('conv_hypothecs')->insert([
            'id' => '9bce26d8-32c0-4b96-afcd-300d051cf9f0',
            'state' => 'created',
            'step' => 'formalization',
            'reference' => 'HC-1234',
            'name' => 'Test init. convention d\'hypothèque',
            'contract_file' => 'guarantee/conventionnal_hypothec/2024-04-14_131932-tpa33X-sun_tzu_art_de_la_guerre_.pdf',
        ]);

        $convHypo = ConvHypothec::find('9bce26d8-32c0-4b96-afcd-300d051cf9f0');

        $all_steps = ConvHypothecStep::orderBy('rank')->whereType('formalization')->get();

        $convHypo->steps()->syncWithoutDetaching($all_steps);

        $this->updatePivotState($convHypo);

        $this->info('Test data has been filled successfully');
    }

    public function updatePivotState($convHypo)
    {
        if ($convHypo->state == ConvHypothecState::REGISTER && $convHypo->is_approved == true) {
            $all_steps = ConvHypothecStep::orderBy('rank')->whereType('realization')->get();

            $convHypo->steps()->syncWithoutDetaching($all_steps);
        }
        $currentStep = $this->currentStep($convHypo->state);

        if ($currentStep) {
            $pivotValues = [
                $currentStep->id => ['status' => true],
            ];
            $convHypo->steps()->syncWithoutDetaching($pivotValues);
        }
    }

    public function currentStep($state)
    {
        return ConvHypothecStep::whereCode($state)->first();
    }
}

<?php

namespace App\Console\Commands;

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
    }
}

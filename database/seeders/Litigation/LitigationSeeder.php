<?php
namespace Database\Seeders\Litigation;

use App\Models\Litigation\Litigation;
use App\Models\Litigation\LitigationParty;
use App\Models\Litigation\LitigationSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LitigationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create a new litigation
        /*
        'name' => $request->name,
            'reference' => $request->reference,
            'nature_id' => $request->nature_id,
            'party_id' => $request->party_id,
            'jurisdiction_id' => $request->jurisdiction_id,
            'email' => $request->email,
            'phone' => $request->phone,
        */
        $litigation = DB::table('litigations')->insert([
            'id' => '9bce26d8-32c0-4b96-afcd-300d051cf9f0', // '9bce26d8-32c0-4b96-afcd-300d051cf9f0' is a UUID
            'name' => 'Test init. litigation',
            'reference' => 'LIT-1234',
            'nature_id' => LitigationSetting::whereType('nature')->first()->id,
            'party_id' => LitigationParty::first()->id,
            'jurisdiction_id' => LitigationSetting::whereType('jurisdiction')->first()->id,
            'jurisdiction_location' => 'Lagos',
        ]);
        $litigation = Litigation::first();
        $party = LitigationParty::first();
        $party->litigations()->attach($litigation, ['category' => 'intervenant', 'type' => 'client']);
    }
}

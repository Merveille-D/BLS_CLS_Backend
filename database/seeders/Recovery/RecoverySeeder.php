<?php
namespace Database\Seeders\Recovery;

use App\Models\Litigation\Litigation;
use App\Models\Litigation\LitigationParty;
use App\Models\Litigation\LitigationSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecoverySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $litigation = DB::table('recoveries')->insert([
            'id' => 'aaa726d8-32c0-4b96-afcd-300d051cf9f0', // '9bce26d8-32c0-4b96-afcd-300d051cf9f0' is a UUID
            'name' => 'Test init. litigation',
            'type' => 'friendly',
            'reference' => 'LIT-1234',
        ]);
        // $party->litigations()->attach($litigation, ['category' => 'intervenant', 'type' => 'client']);
    }
}

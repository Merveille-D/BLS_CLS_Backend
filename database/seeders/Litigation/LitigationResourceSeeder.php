<?php

namespace Database\Seeders\Litigation;

use App\Enums\Litigation\LitigationType;
use App\Models\Litigation\LitigationParty;
use App\Models\Litigation\LitigationSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LitigationResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $resources = $this->litigation_natures();
        foreach ($resources as $resource) {
            $exist = LitigationSetting::where('name', $resource)->first();
            if (!$exist) {
                LitigationSetting::create(['name' => $resource, 'type' => LitigationType::NATURE] );
            }
        }

        $jurisdictions = $this->litigation_jurisdictions();
        foreach ($jurisdictions as $jurisdiction) {
            $exist = LitigationSetting::where('name', $jurisdiction)->first();
            if (!$exist) {
                LitigationSetting::create(['name' => $jurisdiction, 'type' => LitigationType::JURISDICTION] );
            }
        }

        // create default litigation for test
        DB::table('litigation_parties')->insert([
            'id' => '9bce26d8-32c0-4b96-afcd-300d051cf9f8',
            'name' => 'John Doe',
            'type' => 'individual',
            'address' => '123, Test Street, Lagos City',
            'phone' => '123456789',
            'email' => 'test@test.com'
        ]);

        DB::table('litigation_parties')->insert([
            'id' => '7ace26d8-32c0-4b96-afcd-300d051cf9f8',
            'name' => 'Société de ciment',
            'type' => 'legal',
            'address' => '123, Test Street, Lagos City',
            'phone' => '+23121452125',
            'email' => 'testste@test.com'
        ]);
    }

    /**
     * nature default seeds
     *
     * @return array
     */
    public function litigation_natures() : array {
        return [
            'Administrative',
            'Civile',
            'Commerciale',
            'Penale',
            'Sociale',
        ];
    }

    /**
     * jurisdictions default seeds
     *
     * @return array
     */
    public function litigation_jurisdictions() : array {
        return [
            'Tribunal de Première Instance',
            'Tribunal de Commerce',
            'Tribunal Administratif',
            'Cour d\'Appel',
            'Cour Suprême ',
            'Cour Constitutionnelle',
        ];
    }
}

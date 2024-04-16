<?php

namespace Database\Seeders\Litigation;

use App\Enums\Litigation\LitigationType;
use App\Models\Litigation\LitigationParty;
use App\Models\Litigation\LitigationSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
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

        LitigationParty::create( [
            'name' => 'Test init. litigation party',
            'category' => 'intervenant',
            'type' => 'client',
            'phone' => '123456789',
            'email' => 'test@test.com'
        ] );
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

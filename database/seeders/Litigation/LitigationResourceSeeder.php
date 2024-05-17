<?php

namespace Database\Seeders\Litigation;

use App\Enums\Litigation\LitigationTaskState;
use App\Enums\Litigation\LitigationType;
use App\Models\Litigation\LitigationParty;
use App\Models\Litigation\LitigationSetting;
use App\Models\Litigation\LitigationStep;
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

        $steps = $this->defaultSteps();

        foreach ($steps as $step) {
            LitigationStep::create($step);
        }

        // create default litigation for test
        DB::table('litigation_parties')->insert([
            'id' => '9bce26d8-32c0-4b96-afcd-300d051cf9f8',
            'name' => 'John Cakpo',
            'type' => 'individual',
            'address' => '123, Test Street, Lagos City',
            'phone' => '+22845869535',
            'email' => 'johncakpo@gmail.com'
        ]);
        /* DB::table('litigation_parties')->insert([
            'id' => '9bce26d8-3290-4b96-afcd-300d051cf458',
            'name' => 'John Cakpo',
            'type' => 'individual',
            'address' => '123, Test Street, Lagos City',
            'phone' => '123456789',
            'email' => 'johncakpo@afrikskills.com'
        ]); */

        DB::table('litigation_parties')->insert([
            'id' => '9bce26d8-32c0-4b96-afcd-300d0jk9f9f8',
            'name' => 'Jonathan Agbo',
            'type' => 'individual',
            'address' => '123, Test Street, Lagos City',
            'phone' => '+2296600252510',
            'email' => 'jagbo@hotmail.com'
        ]);

        DB::table('litigation_parties')->insert([
            'id' => 'jko526d8-32c0-4b96-afcd-300d051cf9f8',
            'name' => 'Société Afrikskills SAS',
            'type' => 'legal',
            'address' => '123, Test Street, Lagos City',
            'phone' => '+22945253654',
            'email' => 'societe@afrikskills.com'
        ]);
        DB::table('litigation_parties')->insert([
            'id' => '7ace26d8-85kj-4b96-afcd-300d051cf9f8',
            'name' => 'Société Bamoui SA',
            'type' => 'legal',
            'address' => '123, Test Street, Lagos City',
            'phone' => '+23121452125',
            'email' => 'societe@bamoui.com'
        ]);
        DB::table('litigation_parties')->insert([
            'id' => '7ace26d8-32c0-kiol-afcd-300d051cf9f8',
            'name' => 'Société Adjibi & fils SARL',
            'type' => 'legal',
            'address' => '123, Test Street, Lagos City',
            'phone' => '+22921145865',
            'email' => 'societe@afrikskills.com'
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
            'Cour d\'Appel',
            'Cour Constitutionnelle',
            'Cour Suprême ',
            'Tribunal Administratif',
            'Tribunal Arbitral',
            'Tribunal de Commerce',
            'Tribunal de Première Instance',
        ];
    }


    public function defaultSteps() : array {
        return [

            [
                'title' => 'Enregistrement du dossier',
                'code' => LitigationTaskState::CREATED,
                'rank' => 1,
                'type' => 'step',
                'min_delay' => null,
                'type' => 'step',
                'max_delay' => 10,
            ],
            [
                'title' => 'Transférer le dossier à l\'avocat',
                'code' => LitigationTaskState::TRANSFER,
                'rank' => 2,
                'min_delay' => null,
                'type' => 'step',
                'max_delay' => 10,
            ],
            [
                'title' => 'Saisine de la juridiction compétente',
                'code' => LitigationTaskState::REFERRAL,
                'rank' => 3,
                'min_delay' => null,
                'type' => 'step',
                'max_delay' => 5,
            ],
            [
                'title' => 'Date première Audience',
                'code' => LitigationTaskState::HEARING,
                'rank' => 4,
                'min_delay' => null,
                'type' => 'step',
                'max_delay' => 10,
            ],
            [
                'title' => 'Rapport de l\'audience',
                'code' => LitigationTaskState::REPORT,
                'rank' => 5,
                'min_delay' => null,
                'type' => 'step',
                'max_delay' => 10,
            ],
            [
                'title' => 'DÉCISION',
                'code' => LitigationTaskState::DECISION,
                'rank' => 6,
                'min_delay' => null,
                'type' => 'step',
                'max_delay' => 10,
            ],
        ];
    }
}

<?php

namespace Database\Seeders\Litigation;

use App\Models\Litigation\LitigationLawyer;
use Illuminate\Database\Seeder;

class LawyerSeeder extends Seeder
{
    public function run()
    {
        $lawyers = [
            [
                'name' => 'Cabinet d\'avocat de Maitre Lionel Samou',
                'email' => 'lionel1980sam@yahoo.com',
                'phone' => +22967868890,
            ],
            [
                'name' => 'Cabinet d\'avocat de Maitre Josué SALANON',
                'email' => 'jsalanon@gmail.com',
                'phone' => +22982567890,
            ],
            [
                'name' => 'Cabinet d\'avocat de Maitre Christine ADIVI',
                'email' => 'christineadivi75@gmail.com',
                'phone' => +310144567890,
            ],
        ];

        foreach ($lawyers as $lawyer) {
            LitigationLawyer::create($lawyer);
        }
    }
}

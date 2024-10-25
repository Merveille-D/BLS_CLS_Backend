<?php

namespace Database\Seeders\Contract;

use App\Models\Contract\Part;
use Illuminate\Database\Seeder;

class PartSeeder extends Seeder
{
    public function run()
    {
        $parts = [
            [
                'name' => 'Jacob HOUESSOU',
                'email' => 'jacobhouessou@gmail.com',
                'type' => 'individual',
                'telephone' => '98456798',
                'residence' => 'Fidjrossè',
                'id_card' => '238467',
                'zip_code' => '476',
            ],
            [
                'name' => 'Carlos KPANOU',
                'email' => 'carloskpannou@gmail.com',
                'type' => 'individual',
                'telephone' => '98456798',
                'residence' => 'Fidjrossè',
                'id_card' => '238467',
                'zip_code' => '476',
            ],
            [
                'name' => 'MC Bank',
                'email' => 'mcbank@mcb.com',
                'type' => 'corporate',
                'telephone' => '98456798',
                'residence' => 'Benin',
                'id_card' => '238467',
                'zip_code' => '476',
            ],
            [
                'name' => 'Benin International Bank',
                'email' => 'benininter@bib.com',
                'type' => 'corporate',
                'telephone' => '98456798',
                'residence' => 'Benin',
                'id_card' => '238467',
                'zip_code' => '476',
            ],
        ];

        foreach ($parts as $part) {
            Part::create($part);
        }
    }
}

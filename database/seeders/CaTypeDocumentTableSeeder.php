<?php

namespace Database\Seeders;

use App\Models\Gourvernance\BoardDirectors\Administrators\CaTypeDocument;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CaTypeDocumentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CaTypeDocument::create([
            'name'  => 'Procès verbal',
        ]);
    }
}

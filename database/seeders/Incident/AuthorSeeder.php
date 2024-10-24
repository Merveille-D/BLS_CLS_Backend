<?php

namespace Database\Seeders\Incident;

use App\Models\Incident\AuthorIncident;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    public function run()
    {
        $authors = [
            [
                'name' => 'John Doe',
                'email' => 'avocat@test.com',
                'telephone' => '+1234568890',
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'test@gmail.com',
                'telephone' => '+1234567890',
            ],
        ];

        foreach ($authors as $author) {
            AuthorIncident::create($author);
        }
    }
}

<?php
namespace Database\Seeders\Litigation;
use Illuminate\Database\Seeder;
use App\Models\Litigation\LitigationLawyer;
class LawyerSeeder extends Seeder
{
    public function run()
    {
        $lawyers = [
            [
                'name' => 'John Doe',
                'email' => 'avocat@test.com',
                'phone' => +1234568890,
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'test@gmail.com',
                'phone' => +1234567890,
            ],
            [
                'name' => 'John Smith',
                'email' => 'john@test.com',
                'phone' => +1234567890,
            ],
        ];

        foreach ($lawyers as $lawyer) {
            LitigationLawyer::create($lawyer);
        }
    }
}

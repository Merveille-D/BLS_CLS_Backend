<?php

namespace Tests\Feature;

use App\Models\Litigation\LitigationParty;
use App\Models\Litigation\LitigationSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LitigationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_retrieve_list()
    {

        $response = $this->get('api/litigation');

        // Assert that the response has a 200 status code
        $response->assertStatus(200);

        // Assert that the response contains the correct number of litigations
        // $response->assertJsonCount(5);
    }

    public function test_save_litigation()
    {
        $file = UploadedFile::fake()->create(
            'document.pdf', 2048, 'application/pdf'
        );

        $response = $this->post('api/litigation', [
            'name' => 'Test Litigation',
            'reference' => 'LT-1234',
            'nature_id' => LitigationSetting::whereType('nature')->first()->id,
            // 'party_id' => LitigationParty::first()->id,
            'jurisdiction_id' => LitigationSetting::whereType('jurisdiction')->first()->id,
            'jurisdiction_location' => 'Lagos',
            'parties' => [
                [
                    'party_id' =>  LitigationParty::first()->id,
                    'category' => 'intervenant',
                    'type' => 'client',
                ],
            ],
            'documents' => [
                [
                    'name' => 'Test Document',
                    'file' => $file,
                ],
            ],
        ]);

        // Assert that the response has a 201 status code
        $response->assertStatus(200);

        // Assert that the litigation was created in the database
        $this->assertDatabaseHas('litigations', [
            'name' => 'Test Litigation',
            'reference' => 'LT-1234',
        ]);
    }
}

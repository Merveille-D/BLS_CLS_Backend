<?php

namespace Tests\Feature;

use App\Models\Litigation\LitigationParty;
use App\Models\Litigation\LitigationSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class LitigationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @test
     */
    public function retrieve_list()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('api/litigation');

        // Assert that the response has a 200 status code
        $response->assertStatus(200);

        // Assert that the response contains the correct number of litigations
        // $response->assertJsonCount(5);
    }

    /**
     * @test
     */
    public function save_litigation()
    {
        $user = User::factory()->create();
        $file = UploadedFile::fake()->create(
            'document.pdf', 2048, 'application/pdf'
        );

        $response = $this->actingAs($user)->post('api/litigation', [
            'name' => 'Test Litigation',
            'case_number' => 'LT-1234',
            'nature_id' => LitigationSetting::whereType('nature')->first()->id,
            // 'party_id' => LitigationParty::first()->id,
            'has_provisions' => true,
            'jurisdiction_id' => LitigationSetting::whereType('jurisdiction')->first()->id,
            'jurisdiction_location' => 'Lagos',
            'parties' => [
                [
                    'party_id' => LitigationParty::first()->id,
                    'category' => 'intervenant',
                    // 'type_id' => LitigationSetting::whereType('party_type')->first()->id,
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
            'case_number' => 'LT-1234',
        ]);

        // Assert that the litigation has tasks saved
        $this->assertDatabaseHas('module_tasks', [
            'status' => 1,
            // 'title' => 'Enregistrement du dossier',
            'taskable_type' => 'App\Models\Litigation\Litigation',
            'created_by' => $user->id,
            'taskable_id' => $response->json('data.id'),
        ]);
    }

    /**
     * test retrieve single litigation
     *
     * @test
     */
    public function retrieve_litigation(): void
    {
        $user = User::factory()->create();

        $file = UploadedFile::fake()->create(
            'document.pdf', 2048, 'application/pdf'
        );

        $litigation = $this->actingAs($user)->post('api/litigation', [
            'name' => 'Test Litigation',
            'case_number' => 'LT-1234',
            'nature_id' => LitigationSetting::whereType('nature')->first()->id,
            'jurisdiction_id' => LitigationSetting::whereType('jurisdiction')->first()->id,
            'jurisdiction_location' => 'Lagos',
            'parties' => [
                [
                    'party_id' => LitigationParty::first()->id,
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

        $id = $litigation->json('data.id');

        $response = $this->actingAs($user)->get('api/litigation/' . $id);

        // Assert that the response has a 200 status code
        $response->assertStatus(200);
    }

    /**
     * test generate pdf
     *
     * @test
     */
    public function generate_litigation_pdf(): void
    {
        $user = User::factory()->create();
        $file = UploadedFile::fake()->create(
            'document.pdf', 2048, 'application/pdf'
        );

        $litigation_creating = $this->actingAs($user)->post('api/litigation', [
            'name' => 'Test Litigation',
            'case_number' => 'LT-1234',
            'nature_id' => LitigationSetting::whereType('nature')->first()->id,
            'jurisdiction_id' => LitigationSetting::whereType('jurisdiction')->first()->id,
            'jurisdiction_location' => 'Lagos',
            'has_provisions' => true,
            'parties' => [
                [
                    'party_id' => LitigationParty::first()->id,
                    'category' => 'intervenant',
                    // 'type_id' => LitigationSetting::whereType('party_type')->first()->id,
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

        $id = $litigation_creating->json('data.id');

        $response = $this->get('/api/litigation/generate-pdf/' . $id);
        $response->assertStatus(200);
    }
}

<?php

namespace Tests\Feature;

use App\Enums\ConvHypothecState;
use App\Models\Guarantee\ConvHypothec;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Testing\Fakes\Fake;
use Tests\TestCase;

class HypothecTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_retrieve_list()
    {
        // Create some hypothec instances in the database
        // Hypothec::factory()->count(5)->create();

        // Send a GET request to the endpoint
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('api/conventionnal_hypothec');

        // Assert that the response has a 200 status code
        $response->assertStatus(200);

        // Assert that the response contains the correct number of hypothecs
        // $response->assertJsonCount(5);
    }

    public function test_save_new_hypothec() {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('api/conventionnal_hypothec', [
            'name' => 'Test Hypothec',
            'reference' => 'ABC123',
            'contract_id'=> 'sdlkfaz-sdfas-1234-sdfas',
        ]);

        // Assert that the response has a 201 status code
        $response->assertStatus(200);

        // Assert that the hypothec was created in the database
        $this->assertDatabaseHas('conv_hypothecs', [
            'name' => 'Test Hypothec',
            'contract_id'=> 'sdlkfaz-sdfas-1234-sdfas',
        ]);
    }

    public function test_if_retrieved_hypothec_has_some_attributes() : void {
        $user = User::factory()->create();

        $hypothec = $this->actingAs($user)->post('api/conventionnal_hypothec', [
            'name' => 'Test Hypothec',
            'reference' => 'ABC123',
            'contract_id'=> 'sdlkfaz-sdfas-1234-sdfas',
        ]);
        $hypothec_id = $hypothec->json('data.id');

        $this->actingAs($user)->get('api/conventionnal_hypothec/'.$hypothec_id)->assertJsonStructure([
            'success',
            'message',
            'data' => [
                    'id',
                    'name',
                    'state',
                    'reference',
                    'contract_id',
                    'next_step' => [
                        'id',
                        'title',
                        'code',
                        'min_deadline',
                        'max_deadline',
                        'type',
                    ],
                    'current_step' => [
                        'id',
                        'title',
                        'code',
                        'min_deadline',
                        'max_deadline',
                        'type',
                    ],
                    'created_at',
            ]
        ]);
    }

    public function test_if_tasks_successfully_created_after_hypothec_created() : void {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('api/conventionnal_hypothec', [
            'name' => 'Test Hypothec',
            'reference' => 'ABC123',
            'contract_id'=> 'sdlkfaz-sdfas-1234-sdfas',
        ]);

        // Assert that the response has a 201 status code
        $response->assertStatus(200);

        // Assert that the hypothec was created in the database
        $this->assertDatabaseHas('conv_hypothecs', [
            'name' => 'Test Hypothec',
            'contract_id'=> 'sdlkfaz-sdfas-1234-sdfas',
        ]);

        // Assert that the tasks were created in the database
        $this->assertDatabaseHas('module_tasks', [
            'title' => 'Initiation de l\'hypothèque',
        ]);

        $this->assertDatabaseHas('module_tasks', [
            'title' => 'Vérifier la propriété de l\'immeuble',
        ]);

        $this->assertDatabaseHas('module_tasks', [
            'title' => 'Rédiger la convention d\'hypothèque',
        ]);
    }

    /**
     * test_formalization_process
     * test the formalization process completely
     *
     * @return void
     */
    public function test_formalization_process() : void {

        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('api/conventionnal_hypothec', [
            'name' => 'Test Hypothec Conventionnelle',
            'reference' => 'ABC123',
            'contract_id'=> 'sdlkfaz-sdfas-1234-sdfas',
        ]);
        $response->assertStatus(200);

        $documents = [
            [
                'name' => 'Test Document',
                'file' => UploadedFile::fake()->create(
                    'document.pdf', 2048, 'application/pdf'
                )
            ],
        ];

        $hypothec_id = $response->json('data.id');
        $verifyProperty = $this->actingAs($user)->post('api/conventionnal_hypothec/update/'.$hypothec_id, [
            'documents' => $documents
        ]);

        $verifyProperty->assertStatus(200);

        $agreement = $this->actingAs($user)->post('api/conventionnal_hypothec/update/'.$hypothec_id, [
            'documents' => $documents
        ]);

        $agreement->assertStatus(200);

        $this->assertDatabaseHas('conv_hypothecs', [
            'state' => ConvHypothecState::AGREEMENT_SIGNED
        ]);

        $forwarded = $this->actingAs($user)->post('api/conventionnal_hypothec/update/'.$hypothec_id, [
            'documents' => $documents,
            'forwarded_date' => date('Y-m-d')
        ]);

        $forwarded->assertStatus(200);

        $this->assertDatabaseHas('conv_hypothecs', [
            'state' => ConvHypothecState::REGISTER_REQUEST_FORWARDED
        ]);

        $register_requested = $this->actingAs($user)->post('api/conventionnal_hypothec/update/'.$hypothec_id, [
            'documents' => $documents,
            'registering_date' => date('Y-m-d')
        ]);

        $register_requested->assertStatus(200);

        $this->assertDatabaseHas('conv_hypothecs', [
            'state' => ConvHypothecState::REGISTER_REQUESTED,
            'registering_date' => date('Y-m-d')
        ]);

        $registered = $this->actingAs($user)->post('api/conventionnal_hypothec/update/'.$hypothec_id, [
            'documents' => $documents,
            'is_approved' => 'yes',
            'registration_date' => date('Y-m-d')
        ]);

        $registered->assertStatus(200);

        $this->assertDatabaseHas('conv_hypothecs', [
            'state' => ConvHypothecState::REGISTER,
            'registration_date' => date('Y-m-d'),
            'is_approved' => true
        ]);

    }

    /**
     * test_initiate_realization_process
     *
     * @return void
     */
    public function test_initiate_realization_process() : void {

    }
}

<?php

namespace Tests\Feature;

use App\Enums\ConvHypothecState;
use App\Models\Guarantee\ConvHypothec;
use App\Models\Guarantee\Guarantee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Testing\Fakes\Fake;
use Tests\TestCase;

class MortgageTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_retrieve_list()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('api/guarantees', [
            'security' => 'property',
        ]);

        // Assert that the response has a 200 status code
        $response->assertStatus(200);

    }

    public function test_save_new_hypothec() {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('api/guarantees', [
            'name' => 'Test Hypothec',
            'contract_id'=> '9c2305a7-c6f8-4473-99a0-9cf055044ee1',
            'type' => 'mortgage',
        ]);

        // Assert that the response has a 201 status code
        $response->assertStatus(201);

        // Assert that the hypothec was created in the database
        $this->assertDatabaseHas('guarantees', [
            'name' => 'Test Hypothec',
            'contract_id'=> '9c2305a7-c6f8-4473-99a0-9cf055044ee1',
        ]);

        //asserts module tasks are generated successfully
        $this->assertDatabaseHas('module_tasks', [
            'taskable_id' => $response->json('data.id'),
        ]);
    }

    public function test_if_retrieved_hypothec_has_some_attributes() : void {
        $user = User::factory()->create();

        $hypothec = $this->actingAs($user)->post('api/guarantees', [
            'name' => 'Test Hypothec',
            'contract_id'=> '9c2305a7-c6f8-4473-99a0-9cf055044ee1',
            'type' => 'mortgage',
        ]);
        $hypothec_id = $hypothec->json('data.id');

        $this->actingAs($user)->get('api/guarantees/'.$hypothec_id)->assertJsonStructure([
            'success',
            'message',
            'data' => [
                    'id',
                    'name',
                    'status',
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

    /**
     * test_formalization_process
     * test the formalization process completely
     *
     * @return void
     */
    public function test_formalization_process() : void {

        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('api/guarantees', [
            'name' => 'Test Hypothec Conventionnelle',
            'contract_id'=> '9c2305a7-c6f8-4473-99a0-9cf055044ee1',
            'type' => 'mortgage',
        ]);

        $documents = [
            [
                'name' => 'Test Document',
                'file' => UploadedFile::fake()->create(
                    'document.pdf', 2048, 'application/pdf'
                )
            ],
        ];

        $hypothec_id = $response->json('data.id');
        $next_step_id = Guarantee::find($hypothec_id)->next_task->id;

        $verifyProperty = $this->actingAs($user)->post('api/guarantees/tasks/complete/'.$next_step_id, [
            'documents' => $documents
        ]);

        $verifyProperty->assertStatus(200);

        $this->assertDatabaseHas('module_tasks', [
            'id' => $next_step_id,
            'status' => true
        ]);

        $agreement = $this->actingAs($user)->post('api/guarantees/tasks/complete/'.Guarantee::find($hypothec_id)->next_task->id, [
            'documents' => $documents
        ]);

        $agreement->assertStatus(200);

        // $this->assertDatabaseHas('conv_hypothecs', [
        //     'state' => ConvHypothecState::AGREEMENT_SIGNED
        // ]);

        // $forwarded = $this->actingAs($user)->post('api/guarantees/tasks/complete/'.$hypothec_id, [
        //     'documents' => $documents,
        //     'forwarded_date' => date('Y-m-d')
        // ]);

        // $forwarded->assertStatus(200);

        // $this->assertDatabaseHas('conv_hypothecs', [
        //     'state' => ConvHypothecState::REGISTER_REQUEST_FORWARDED
        // ]);

        // $register_requested = $this->actingAs($user)->post('api/conventionnal_hypothec/update/'.$hypothec_id, [
        //     'documents' => $documents,
        //     'registering_date' => date('Y-m-d')
        // ]);

        // $register_requested->assertStatus(200);

        // $this->assertDatabaseHas('conv_hypothecs', [
        //     'state' => ConvHypothecState::REGISTER_REQUESTED,
        //     'registering_date' => date('Y-m-d')
        // ]);

        // $registered = $this->actingAs($user)->post('api/conventionnal_hypothec/update/'.$hypothec_id, [
        //     'documents' => $documents,
        //     'is_approved' => 'yes',
        //     'registration_date' => date('Y-m-d')
        // ]);

        // $registered->assertStatus(200);

        // $this->assertDatabaseHas('conv_hypothecs', [
        //     'state' => ConvHypothecState::REGISTER,
        //     'registration_date' => date('Y-m-d'),
        //     'is_approved' => true
        // ]);

    }

    /**
     * test trnasfer task to user
     */
    /* public function test_transfer_task_to_user() : void {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('api/conventionnal_hypothec', [
            'name' => 'Test Hypothec Conventionnelle',
            'contract_id'=> '9c2305a7-c6f8-4473-99a0-9cf055044ee1',
        ]);

        $hypothec_id = $response->json('data.id');
        $tasks = $this->actingAs($user)->get('api/conventionnal_hypothec/tasks', [
            'id' => $hypothec_id,
        ]);

        $task = $tasks->json('data');

        dd($task);
    } */
    /**
     * test_initiate_realization_process
     *
     * @return void
     */
    public function test_initiate_realization_process() : void {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('api/guarantees', [
            'name' => 'Test Hypothec Conventionnelle',
            'contract_id'=> '9c2305a7-c6f8-4473-99a0-9cf055044ee1',
            'type' => 'mortgage',
        ]);
        $response->assertStatus(201);

        $documents = [
            [
                'name' => 'Test Document',
                'file' => UploadedFile::fake()->create(
                    'document.pdf', 2048, 'application/pdf'
                )
            ],
        ];

        $hypothec_id = $response->json('data.id');
        $verifyProperty = $this->actingAs($user)->post('api/guarantees/tasks/complete/'.Guarantee::find($hypothec_id)->next_task->id, [
            'documents' => $documents
        ]);

        $agreement = $this->actingAs($user)->post('api/guarantees/tasks/complete/'.Guarantee::find($hypothec_id)->next_task->id, [
            'documents' => $documents
        ]);

        $forwarded = $this->actingAs($user)->post('api/guarantees/tasks/complete/'.Guarantee::find($hypothec_id)->next_task->id, [
            'documents' => $documents,
        ]);

        $register_requested = $this->actingAs($user)->post('api/guarantees/tasks/complete/'.Guarantee::find($hypothec_id)->next_task->id, [
            'documents' => $documents,
        ]);

        $registered = $this->actingAs($user)->post('api/guarantees/tasks/complete/'.Guarantee::find($hypothec_id)->next_task->id, [
            'documents' => $documents,
            'is_approved' => 'yes',
        ]);

        $realization = $this->actingAs($user)->post('api/guarantees/realization/'.$hypothec_id);

        $realization->assertStatus(200);

        $this->assertDatabaseHas('guarantees', [
            'phase' => 'realization',
            'name' => 'Test Hypothec Conventionnelle',
            'contract_id'=> '9c2305a7-c6f8-4473-99a0-9cf055044ee1',
        ]);

        $this->assertDatabaseHas('module_tasks', [
            'code' => ConvHypothecState::SIGNIFICATION_REGISTERED,
            'status' => false,
            'taskable_id' => $hypothec_id,
        ]);

    }

    /**
     * test_full_realization_process
     *
     * @return void
     */
    public function test_full_realization_process() : void {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('api/conventionnal_hypothec', [
            'name' => 'Test Hypothec Conventionnelle',
            'contract_id'=> '9c2305a7-c6f8-4473-99a0-9cf055044ee1',
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
        $verifyProperty = $this->actingAs($user)->post('api/guarantees/tasks/complete/'.$hypothec_id, [
            'documents' => $documents
        ]);

        $agreement = $this->actingAs($user)->post('api/guarantees/tasks/complete/'.$hypothec_id, [
            'documents' => $documents
        ]);

        $forwarded = $this->actingAs($user)->post('api/guarantees/tasks/complete/'.$hypothec_id, [
            'documents' => $documents,
            'forwarded_date' => date('Y-m-d')
        ]);

        $register_requested = $this->actingAs($user)->post('api/guarantees/tasks/complete/'.$hypothec_id, [
            'documents' => $documents,
            'registering_date' => date('Y-m-d')
        ]);

        $registered = $this->actingAs($user)->post('api/guarantees/tasks/complete/'.$hypothec_id, [
            'documents' => $documents,
            'is_approved' => 'yes',
            'registration_date' => date('Y-m-d')
        ]);

        $realization = $this->actingAs($user)->post('api/conventionnal_hypothec/realization/'.$hypothec_id);

        $realization->assertStatus(200);

        // $this->assertDatabaseHas('conv_hypothecs', [
        //     'step' => 'realization',
        //     'name' => 'Test Hypothec Conventionnelle',
        //     'contract_id'=> '9c2305a7-c6f8-4473-99a0-9cf055044ee1',
        // ]);

        // $realization = $this
    }
}

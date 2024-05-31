<?php

namespace Tests\Feature;

use App\Enums\Recovery\RecoveryStepEnum;
use App\Models\Auth\Subsidiary;
use App\Models\Recovery\Recovery;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\Feature\Traits\WithStubUser;
use Tests\TestCase;

class RecoveryTest extends TestCase
{
    use RefreshDatabase, WithStubUser;

    /**
     * Test retrieving a list of recoveries.
     *
     * @return void
     */
    public function testRetrieveList(): void
    {
        $user = User::factory()->create();

        Recovery::factory()->count(1)->create();

        $response = $this->actingAs($user)->get('api/recovery');

        // Assert that the response has a 200 status code
        $response->assertStatus(200);

        // Assert that the response contains the correct number of recoveries
        // $response->assertJsonCount(5);
    }

    /**
     * Test retrieving a single recovery.
     *
     * @return void
     */
    public function testRetrieveSingle(): void
    {
        // $subsidiary = Subsidiary::factory()->create();
        // $user = User::factory()->create([
        //     'subsidiary_id' => $subsidiary->id,
        // ]);
        $user = $this->stubUser();

        $recovery = Recovery::factory()->create([
            'created_by' => $user->id,
        ]);

        $response = $this->actingAs($user)->get("api/recovery/{$recovery->id}");

        // Assert that the response has a 200 status code
        $response->assertStatus(200);

        // Assert that the response contains the correct recovery
        $response->assertJson([
            'data' => [
                'id' => $recovery->id,
                'name' => $recovery->name,
                'type' => $recovery->type,
                'has_guarantee' => $recovery->has_guarantee,
                'guarantee_id' => $recovery->guarantee_id,
                'contract_id' => $recovery->contract_id,
            ],
        ]);
    }

    /**
     * Test creating a new recovery.
     *
     * @return void
     */
    public function test_create_friendly_with_guarante_recovery(): void
    {
        $user = User::factory()->create();
        // Send a POST request to the endpoint with the necessary data
        $response = $this->actingAs($user)->post('api/recovery', [
            'name' => 'Test Recovery',
            'reference' => 'ABC123',
            'type'=> 'friendly',
            'has_guarantee' => true,
            'guarantee_id' => '9c077984-2eb2-4efe-9f46-476d0187bf47'
        ]);

        // Assert that the response has a 201 status code
        $response->assertStatus(200);

        // Assert that the recovery was created in the database
        $this->assertDatabaseHas('recoveries', [
            'name' => 'Test Recovery',
            'type'=> 'friendly',
            'has_guarantee' => true,
            //valid uuid
            'guarantee_id' => '9c077984-2eb2-4efe-9f46-476d0187bf47'
        ]);
    }


    /**
     * Test creating a new frinedly recovery without guarantee.
     *
     * @return void
     */
    public function test_create_friendly_without_guarantee_recovery(): void
    {
        $user = User::factory()->create();
        // Send a POST request to the endpoint with the necessary data
        $response = $this->actingAs($user)->post('api/recovery', [
            'name' => 'Test Recovery',
            'type'=> 'friendly',
            'has_guarantee' => false,
            'contract_id' => '9c077984-2eb2-4efe-9f46-476d0187bf47',
        ]);

        // Assert that the response has a 201 status code
        $response->assertStatus(200);

        // Assert that the recovery was created in the database
        $this->assertDatabaseHas('recoveries', [
            'name' => 'Test Recovery',
            'type'=> 'friendly',
            'has_guarantee' => false,
            'contract_id' => '9c077984-2eb2-4efe-9f46-476d0187bf47',
        ]);

        // assert tasks are generated
        $this->assertDatabaseHas('module_tasks', [
            'taskable_id' => $response->json('data.id'),
            'status' => false,
        ]);
    }

    /**
     * Test creating a forced recovery with garantee.
     *
     * @return void
     */

    public function test_create_forced_recovery_with_guarantee(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('api/recovery', [
            'name' => 'Test Recovery',
            'type' => 'forced',
            'has_guarantee' => true,
            'guarantee_id' => '9c077984-2eb2-4efe-9f46-476d0187bf47'
        ]);

        // Assert that the response has a 201 status code
        $response->assertStatus(200);

        // Assert that the recovery was created in the database
        $this->assertDatabaseHas('recoveries', [
            'name' => 'Test Recovery',
            'type' => 'forced',
            'has_guarantee' => true,
            'guarantee_id' => '9c077984-2eb2-4efe-9f46-476d0187bf47',
        ]);
    }

    /**
     * Test creating forced recovery without garantee.
     * @return void
     */
    public function test_create_forced_recovery_without_guarantee(): void
    {
        $user = User::factory()->create();

        // Send a POST request to the endpoint with the necessary data
        $response = $this->actingAs($user)->post('api/recovery', [
            'name' => 'Test Recovery',
            'type' => 'forced',
            'has_guarantee' => false,
            'contract_id' => '9c077984-2eb2-4efe-9f46-476d0187bf47',
        ]);

        // Assert that the response has a 201 status code
        $response->assertStatus(200);

        // Assert that the recovery was created in the database
        $this->assertDatabaseHas('recoveries', [
            'name' => 'Test Recovery',
            'type' => 'forced',
            'has_guarantee' => false,
            'contract_id' => '9c077984-2eb2-4efe-9f46-476d0187bf47',
        ]);

        $this->assertDatabaseHas('module_tasks', [
            'taskable_id' => $response->json('data.id'),
            'status' => false,
        ]);
    }

    /**
     * Test retrieve tasks list.
     *
     * @return void
     */
    public function testRetrieveTasks(): void
    {
        $user = User::factory()->create();

        $recovery = Recovery::factory()->create();

        $response = $this->actingAs($user)->get("api/recovery/tasks?id={$recovery->id}");

        // Assert that the response has a 200 status code
        $response->assertStatus(200);

        // Assert that the response contains the correct recovery
        $response->assertJson([
            'data' => [

            ],
        ]);
    }

    /**
     * Test add new task to a recovery.
     *
     * @return void
     */
    public function testAddTask(): void
    {
        $user = $this->stubUser();

        $recovery = Recovery::factory()->create([
                'created_by' => $user->id,
            ]);

        $response = $this->actingAs($user)->post("api/recovery/tasks", [
            'title' => 'Test Task',
            'deadline' => date('Y-m-d', strtotime('+5 days')),
            'model_id' => $recovery->id,
        ]);

        // Assert that the response has a 201 status code
        $response->assertStatus(201);

        // Assert that the task was created in the database
        $this->assertDatabaseHas('module_tasks', [
            'taskable_id' => $recovery->id,
            'title' => 'Test Task',
            'type' => 'task',
            'max_deadline' => date('Y-m-d', strtotime('+5 days')),
            'created_by' => $user->id,
        ]);
    }

    /**
     * Test update task status.
     *
     * @return void
     */
    /* public function testUpdateTaskStatus(): void
    {
        $user = User::factory()->create();

        $recovery = Recovery::factory()->create();

        $task = $recovery->tasks()->create([
            'title' => 'Test Task',
            'type' => 'task',
            'max_deadline' => date('Y-m-d', strtotime('+5 days')),
            'created_by' => $user->id,
        ]);

        $response = $this->actingAs($user)->put("api/recovery/tasks/{$task->id}", [
            'title' => 'edited task',
        ]);

        // Assert that the response has a 200 status code
        $response->assertStatus(200);

        // Assert that the task status was updated in the database
        $this->assertDatabaseHas('module_tasks', [
            'id' => $task->id,
            'title' => 'edited task',
        ]);
    } */

    public function test_generate_pdf() : void {
        $user = $this->stubUser();

        $recovery = Recovery::factory()->create([
            'created_by' => $user->id,
        ]);

        $response = $this->actingAs($user)->get("api/recovery/generate-pdf/{$recovery->id}");

        // Assert that the response has a 201 status code
        $response->assertStatus(200);
    }
}

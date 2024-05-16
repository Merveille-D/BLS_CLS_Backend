<?php

namespace Tests\Feature;

use App\Enums\Recovery\RecoveryStepEnum;
use App\Models\Recovery\Recovery;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RecoveryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test retrieving a list of recoveries.
     *
     * @return void
     */
    public function testRetrieveList(): void
    {
        $user = User::factory()->create();

        Recovery::factory()->count(5)->create();

        $response = $this->actingAs($user)->get('api/recovery');

        // Assert that the response has a 200 status code
        $response->assertStatus(200);

        // Assert that the response contains the correct number of recoveries
        // $response->assertJsonCount(5);
    }

    /**
     * Test creating a new recovery.
     *
     * @return void
     */
    public function test_create_friendly_recovery(): void
    {
        $user = User::factory()->create();
        // Send a POST request to the endpoint with the necessary data
        $response = $this->actingAs($user)->post('api/recovery', [
            'name' => 'Test Recovery',
            'reference' => 'ABC123',
            'type'=> 'friendly'
            // Add other required fields here
        ]);

        // Assert that the response has a 201 status code
        $response->assertStatus(200);

        // Assert that the recovery was created in the database
        $this->assertDatabaseHas('recoveries', [
            'name' => 'Test Recovery',
            'type'=> 'friendly'
            // Add other required fields here
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

        // $hypothec_response = $this->actingAs($user)->post('api/conventionnal_hypothec', [
        //     'name' => 'Test Hypothec',
        //     'contract_id' => 'sdlkfaz-sdfas-1234-sdfas',
        // ]);

        // $hypothecId = $hypothec_response->json('data.id');
        // Send a POST request to the endpoint with the necessary data
        $response = $this->actingAs($user)->post('api/recovery', [
            'name' => 'Test Recovery',
            'type' => 'forced',
            'has_guarantee' => true,
            'guarantee_id' => '9edsdf-ddvzers-xfbfx-xdv'
        ]);

        // Assert that the response has a 201 status code
        $response->assertStatus(200);

        // Assert that the recovery was created in the database
        $this->assertDatabaseHas('recoveries', [
            'name' => 'Test Recovery',
            'type' => 'forced',
            'has_guarantee' => true,
            // 'guarantee_id' => $hypothecId
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
        ]);

        // Assert that the response has a 201 status code
        $response->assertStatus(200);

        // Assert that the recovery was created in the database
        $this->assertDatabaseHas('recoveries', [
            'name' => 'Test Recovery',
            'type' => 'forced',
            'has_guarantee' => false,
        ]);

        $this->assertDatabaseHas('recovery_task', [
            'recovery_id' => $response->json('data.id'),
            'status' => false,
        ]);
    }
}

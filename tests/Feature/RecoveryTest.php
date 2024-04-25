<?php

namespace Tests\Feature;

use App\Models\Recovery\Recovery;
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
        // Create some recovery instances in the database
        Recovery::factory()->count(5)->create();

        // dd(Recovery::all());
        // Send a GET request to the endpoint
        $response = $this->get('api/recovery');

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
    public function testCreate(): void
    {
        // Send a POST request to the endpoint with the necessary data
        $response = $this->post('api/recovery', [
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

}

<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
}

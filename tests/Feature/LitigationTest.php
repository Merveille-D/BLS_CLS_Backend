<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LitigationTest extends TestCase
{
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

    public function test_save_litigation() {

            $response = $this->post('api/litigation', [
                'name' => 'Test Litigation',
                'reference' => 'ABC123',
                'contract_id'=> 'sdlkfaz-sdfas-1234-sdfas',
            ]);

            // Assert that the response has a 201 status code
            // $response->assertStatus(200);

            // // Assert that the litigation was created in the database
            // $this->assertDatabaseHas('litigations', [
            //     'name' => 'Test Litigation',
            //     'contract_id'=> 'sdlkfaz-sdfas-1234-sdfas',
            // ]);
    }
}

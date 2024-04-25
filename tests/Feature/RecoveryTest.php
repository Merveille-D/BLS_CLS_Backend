<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RecoveryTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_retrieve_list(): void
    {
        $response = $this->get('/zfz');

        $response->assertStatus(200);
    }
}

<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GuaranteeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test add new bond guarantee
     *
     * @return void
     */

    public function test_add_new_bond_guarantee()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/api/guarantees', [
            'name' => 'Test Guarantee bonding',
            'type' => 'bonding',
            'contract_id' => '9c077984-2eb2-4efe-9f46-476d0187bf47'
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('guarantees', [
            'name' => 'Test Guarantee bonding',
            'type' => 'bonding',
            'contract_id' => '9c077984-2eb2-4efe-9f46-476d0187bf47'
        ]);

        $this->assertDatabaseHas('module_tasks', [
            'taskable_id' => $response->json('data.id'),
            'taskable_type' => 'App\Models\Guarantee\Guarantee'
        ]);
    }

    /**
     * test get all guarantees
     *
     * @return void
     */

    public function test_get_all_guarantees()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->getJson('/api/guarantees');

        $response->assertStatus(200);
    }

    /**
     * test get one guarantee
     *
     * @return void
     */

    public function test_get_one_guarantee()
    {
        $user = User::factory()->create();

        $guarantee = $this->actingAs($user)->postJson('/api/guarantees', [
            'name' => 'Test Guarantee bonding',
            'type' => 'bonding',
            'contract_id' => '9c088984-2eb2-4efe-9f46-476d0187af47'
        ]);

        $id = $guarantee->json('data.id');

        $response = $this->actingAs($user)->getJson('/api/guarantees/' . $id);

        $response->assertStatus(200);
    }

}
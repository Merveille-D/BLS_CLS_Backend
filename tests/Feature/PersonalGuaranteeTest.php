<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PersonalGuaranteeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test add new bonding guarantee
     *
     * @return void
     *
     * @test
     */
    public function add_and_complete_bonding_guarantee()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/api/guarantees', [
            'name' => 'Test Guarantee stock',
            'type' => 'bonding',
            'contract_id' => '9c077984-2eb2-4efe-9f46-476d0187bf47',
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('guarantees', [
            'name' => 'Test Guarantee stock',
            'security' => 'personal',
            'type' => 'bonding',
            'contract_id' => '9c077984-2eb2-4efe-9f46-476d0187bf47',
        ]);

        $this->assertDatabaseHas('module_tasks', [
            'taskable_id' => $response->json('data.id'),
            'taskable_type' => 'App\Models\Guarantee\Guarantee',
        ]);
    }

    /**
     * test add new bond guarantee
     *
     * @return void
     *
     * @test
     */
    public function add_and_complete_autonomous_guarantee()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/api/guarantees', [
            'name' => 'Test Guarantee stock',
            'type' => 'autonomous',
            'contract_id' => '9c077984-2eb2-4efe-9f46-476d0187bf47',
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('guarantees', [
            'name' => 'Test Guarantee stock',
            'security' => 'personal',
            'type' => 'autonomous',
            'contract_id' => '9c077984-2eb2-4efe-9f46-476d0187bf47',
        ]);

        $this->assertDatabaseHas('module_tasks', [
            'taskable_id' => $response->json('data.id'),
            'taskable_type' => 'App\Models\Guarantee\Guarantee',
        ]);
    }
}

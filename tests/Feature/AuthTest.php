<?php

namespace Tests\Feature;

use App\Models\Auth\Country;
use App\Models\Auth\Role;
use App\Models\Auth\Subsidiary;
use App\Models\User;
use Database\Factories\Auth\SubsidiaryFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test retrieve all users
     *
     * @test
     */
    public function retrieve_all_users(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->getJson('/api/users');

        $response->assertStatus(200);
    }

    /**
     * test retrieve current logged in user
     *
     * @test
     */
    public function retrieve_current_user(): void
    {
        $user = User::factory()->create();
        $role = Role::factory()->create();

        $this->actingAs($user)->postJson('/api/register', [
            'firstname' => 'Julien',
            'lastname' => 'Adimi',
            'username' => 'julienadimi',
            'email' => 'test@example.com',
            'role_id' => $role->id,
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $token = $response->json('data.access_token');

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->getJson('/api/current-user');

        $response->assertStatus(200);

        $response->assertJson([
            'success' => true,
        ]);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'firstname',
                'lastname',
                'email',
                'created_at',
                'updated_at',
            ],
        ]);

    }

    /**
     * test creation role
     *
     * @test
     */
    public function create_role(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->postJson('/api/roles', [
            'name' => 'administrator',
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('roles', [
            'name' => 'administrator',
        ]);
    }

    /**
     * test retrieve all roles
     *
     * @test
     */
    public function retrieve_all_roles(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->getJson('/api/roles');

        $response->assertStatus(200);
    }

    /**
     * test creating new user
     *
     * @test
     */
    public function create_new_user(): void
    {
        $user = User::factory()->create();
        $country = Subsidiary::factory()->create();

        $role_res = $this->actingAs($user)->postJson('/api/roles', [
            'name' => 'administrator',
        ]);

        $role_res->assertStatus(201);

        $role_id = $role_res->json('data.id');
        // create user and assign role
        $response = $this->actingAs($user)->postJson('/api/users', [
            'firstname' => 'Julien',
            'lastname' => 'Adimi',
            'username' => 'julienadimi',
            'email' => 'test@test.com',
            'password' => 'password',
            'role_id' => $role_id,
            'subsidiary_id' => $country->id,
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'firstname' => 'Julien',
            'lastname' => 'Adimi',
            'username' => 'julienadimi',
            'email' => 'test@test.com',
            'subsidiary_id' => $country->id,
        ]);

        $this->assertDatabaseHas('model_has_roles', [
            'role_id' => $role_id,
            'model_id' => $response->json('data.id'),
            'model_type' => 'App\Models\User',
        ]);
    }

    /**
     * test creation country
     *
     * @test
     */
    public function create_country(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->postJson('/api/subsidiaries', [
            'name' => 'Access bank',
            'address' => 'Lagos',
            'country' => 'Nigeria',
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('subsidiaries', [
            'name' => 'Access bank',
            'address' => 'Lagos',
            'country' => 'Nigeria',
        ]);
    }

    /**
     * test depassing country limit
     *
     * @test
     */
    public function depassing_country_limit(): void
    {
        $user = User::factory()->create();
        SubsidiaryFactory::times(5)->create();
        $response = $this->actingAs($user)->postJson('/api/subsidiaries', [
            'name' => 'Access bank',
            'address' => 'Lagos',
            'country' => 'Nigeria',
        ]);

        $response->assertStatus(422);

    }

    /**
     * test retrieve all countries
     *
     * @test
     */
    public function retrieve_all_subsidiaries(): void
    {
        $user = User::factory()
            ->hasRoles(Role::whereName('super_admin')->first())
            ->create();
        $response = $this->actingAs($user)->getJson('/api/subsidiaries');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'success',
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'address',
                    'country',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);
    }

    /**
     * test user login
     *
     * @test
     */
    public function user_login(): void
    {
        $role = Role::factory()->create();
        $user = User::factory()->create();
        $country = Subsidiary::factory()->create();

        $created_user = $this->actingAs($user)->postJson('/api/users', [
            'firstname' => 'Julien',
            'lastname' => 'Adimi',
            'username' => 'julienadimi',
            'email' => 'test@example.com',
            'role_id' => $role->id,
            'subsidiary_id' => $country->id,
        ]);

        $this->assertDatabaseHas('users', [
            'firstname' => 'Julien',
            'lastname' => 'Adimi',
            'username' => 'julienadimi',
            'email' => 'test@example.com',
            'subsidiary_id' => $country->id,
        ]);

        $response = $this->postJson('/api/login', [
            'username' => 'julienadimi',
            'password' => 'password',
        ]);

        $response->assertStatus(200);

        $response->assertJson([
            'success' => true,
        ]);

        $response->assertJsonStructure([
            'data' => [
                'access_token',
            ],
        ]);

    }

    /**
     * test user logout
     *
     * @test
     */
    public function user_logout(): void
    {
        $role = Role::factory()->create();
        $user = User::factory()->create();

        $this->actingAs($user)->postJson('/api/users', [
            'firstname' => 'Julien',
            'lastname' => 'Adimi',
            'username' => 'julienadimi',
            'email' => 'test@example.com',
            'role_id' => $role->id,
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $token = $response->json('data.access_token');

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->postJson('/api/logout');

        $response->assertStatus(200);

        $response->assertJson([
            'success' => true,
        ]);

    }
}

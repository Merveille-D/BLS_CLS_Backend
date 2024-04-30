<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    /**
     * test retrieve all users
     */
    public function test_retrieve_all_users() : void {
        $response = $this->getJson('/api/users');

        $response->assertStatus(200);
    }

    /**
     * test retrieve current logged in user
     */
    public function test_retrieve_current_user() : void {
        $this->postJson('/api/register', [
            'firstname' => 'Julien',
            'lastname' => 'Adimi',
            'email' => 'test@example.com'
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password'
        ]);

        $token = $response->json('data.access_token');

        $response = $this->withHeader('Authorization', 'Bearer '.$token)->getJson('/api/current-user');

        $response->assertStatus(200);

        $response->assertJson([
            'success' => true
        ]);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'firstname',
                'lastname',
                'email',
                'email_verified_at',
                'created_at',
                'updated_at'
            ]
        ]);

    }

    /**
     * test user registration
     */
    public function test_user_registration() : void {
        $response = $this->postJson('/api/register', [
            'firstname' => 'Julien',
            'lastname' => 'Adimi',
            'email' => 'test@example.com'
        ]);

        $response->assertStatus(201);
    }

    /**
     * test user login
     */
    public function test_user_login() : void {
        $this->postJson('/api/register', [
            'firstname' => 'Julien',
            'lastname' => 'Adimi',
            'email' => 'test@example.com'
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password'
        ]);

        $response->assertStatus(200);

        $response->assertJson([
            'success' => true
        ]);

        $response->assertJsonStructure([
            'data' => [
                'access_token'
            ]
        ]);

    }

    /**
     * test user logout
     */

    public function test_user_logout() : void {
        $this->postJson('/api/register', [
            'firstname' => 'Julien',
            'lastname' => 'Adimi',
            'email' => 'test@example.com'
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password'
        ]);

        $token = $response->json('data.access_token');

        $response = $this->withHeader('Authorization', 'Bearer '.$token)->postJson('/api/logout');

        $response->assertStatus(200);

        $response->assertJson([
            'success' => true
        ]);

    }

}

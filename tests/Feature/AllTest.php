<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class AllTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_register_user_and_tenant()
    {
        $data = [
            'name' => 'Erik',
            'email' => 'erik@academlo.com',
            'password' => 'secret12',
            'password_confirmation' => 'secret12',
            'company' => 'academlo'
        ];

        $response = $this->postJson('api/v1/register', $data);
        $response->assertStatus(201);
    }

    public function test_get_collections_status()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $response = $this->get('api/v1/academlo/collections');
        $response->assertStatus(200);
    }

    
    public function test_user_Unauthenticated()
    {
        $data = [];
        $response = $this->postJson('api/v1/academlo/collections', $data);
        $response->assertStatus(401);
    }

    public function test_add_collection_route()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $data = [
            'name' => 'Erik'
        ];
        $response = $this->postJson('api/v1/academlo/collections', $data);
        $response->assertStatus(201);
    }
}

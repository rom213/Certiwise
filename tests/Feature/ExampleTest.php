<?php

namespace Tests\Feature;
use Illuminate\Foundation\Testing\RefreshDatabase;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_can_see_the_documentation_word_in_the_home_page()
    {
        $response = $this->get('/');
        $response -> assertSee('Documentation');
        $response -> assertStatus(200);
    }
}

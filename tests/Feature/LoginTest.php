<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function test_redirectToLogin()
    {
        $response = $this->get('/');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function test_checkLogin()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_checkRegistration()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }
}

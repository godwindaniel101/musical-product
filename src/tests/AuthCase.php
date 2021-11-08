<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class AuthCase extends BaseTestCase
{
    use CreatesApplication ,RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('passport:install', ['--no-interaction' => true,]);

        $this->post('/api/register', [
            "name" => "Godwin Daniel",
            "email" => "godwindaniel101@gmail.com",
            "password" => "password",
            "password_confirmation" => "password"
        ]);

        $response_login = $this->post('/api/auth', [
            "email" => "godwindaniel101@gmail.com",
            "password" => "password",
        ]);

        $response_login->assertStatus(200);

        $data =  $response_login->getOriginalContent();

        $token = $data['data']['token'];

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json'
        ]);

        $this->withoutExceptionHandling();
    }
}

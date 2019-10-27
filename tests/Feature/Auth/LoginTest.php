<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /** @test */
    public function it_requires_an_email()
    {
        $this->json('POST', 'api/auth/login')
            ->assertJsonValidationErrors(['email']);
    }

    /** @test */
    public function it_requires_a_password()
    {
        $this->json('POST', 'api/auth/login')
            ->assertJsonValidationErrors(['password']);
    }

    /** @test */
    public function it_returns_a_validation_error_if_credentials_dont_match()
    {
        $user = factory(User::class)->create([
            'password' => 'foo'
        ]);

        $this->json('POST', 'api/auth/login', [
            'email' => $user->email,
            'password' => 'bar'
        ])
            ->assertJsonValidationErrors(['email']);
    }

    /** @test */
    public function it_returns_a_token_if_credentials_do_match()
    {
        $user = factory(User::class)->create([
            'password' => $passowrd = 'foo'
        ]);

        $this->json('POST', 'api/auth/login', [
            'email' => $user->email,
            'password' => $passowrd
        ])
            ->assertJsonStructure([
                'meta' => [
                    'token'
                ]
            ]);
    }

    /** @test */
    public function it_returns_a_user_if_credentials_do_match()
    {
        $user = factory(User::class)->create([
            'password' => $passowrd = 'foo'
        ]);

        $this->json('POST', 'api/auth/login', [
            'email' => $user->email,
            'password' => $passowrd
        ])
            ->assertJsonFragment([
                'email' => $user->email
            ]);
    }
}

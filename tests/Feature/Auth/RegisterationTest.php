<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterationTest extends TestCase
{
    /** @test */
    public function it_requires_a_name()
    {
        $this->json('POST', 'api/auth/register')
            ->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function it_requires_a_password()
    {
        $this->json('POST', 'api/auth/register')
            ->assertJsonValidationErrors(['password']);
    }

    /** @test */
    public function it_requires_an_email()
    {
        $this->json('POST', 'api/auth/register')
            ->assertJsonValidationErrors(['email']);
    }

    /** @test */
    public function it_requires_a_valid_email()
    {
        $this->json('POST', 'api/auth/register', [
                'email' => 'not_valid_email'
            ])
            ->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function it_requires_a_unique_email()
    {
        $user = factory(User::class)->create();

        $this->json('POST', 'api/auth/register', [
                'email' => $user->email
            ])
            ->assertJsonValidationErrors(['email']);
    }

    /** @test */
    public function it_registers_the_user()
    {
        $this->json('POST', 'api/auth/register', [
                'name' => $name = 'ahmed sayed',
                'email' => $email = 'ahmed@ahmed.com',
                'password' => 'secret'
            ]);

        $this->assertDatabaseHas('users', [
            'name' => $name,
            'email' => $email
        ]);
    }

    /** @test */
    public function it_returns_the_user()
    {
        $this->json('POST', 'api/auth/register', [
                'name' => 'ahmed sayed',
                'email' => $email = 'ahmed@ahmed.com',
                'password' => 'secret' 
            ])
            ->assertJsonFragment([
                'email' => $email
            ]);
    }
}

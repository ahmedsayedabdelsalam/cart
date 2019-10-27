<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MeTest extends TestCase
{
    /** @test */
    public function it_fails_when_user_is_not_authenticated()
    {
        $this->json('GET', 'api/auth/me')
            ->assertStatus(401);
    }

    /** @test */
    public function it_returns_a_user_when_user_is_authenticated()
    {
        $user = factory(User::class)->create();
        
        $this->be($user, 'api')->json('GET', 'api/auth/me')
            ->assertJsonFragment([
                'email' => $user->email
            ]);
    }
}

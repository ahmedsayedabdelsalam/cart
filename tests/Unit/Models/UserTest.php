<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function it_hashes_the_password()
    {
        $user = factory(User::class)->create([
            'password' => $password = 'secret'
        ]);

        $this->assertTrue(\Hash::check($password, $user->password));
    }
}

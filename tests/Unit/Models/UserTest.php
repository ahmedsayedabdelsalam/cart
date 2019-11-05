<?php

namespace Tests\Unit\Models;

use App\Models\ProductVariation;
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

    /** @test */
    public function it_has_many_cart_products()
    {
        $user = factory(User::class)->create();

        $user->cart()->attach(
            factory(ProductVariation::class)->create()
        );

        $this->assertInstanceOf(ProductVariation::class, $user->cart->first());
    }
}

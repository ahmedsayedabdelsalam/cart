<?php

namespace Tests\Feature\Cart;

use App\Models\ProductVariation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CartUpdateTest extends TestCase
{
    /** @test */
    public function it_fails_if_unauthenticated()
    {
        $this->json('PUT', 'api/cart/1')
            ->assertStatus(401);
    }

    /** @test */
    public function it_fails_if_product_can_not_be_found()
    {
        $user = factory(User::class)->create();

        $this->be($user, 'api')
            ->json('PUT', 'api/cart/1')
            ->assertStatus(404);
    }

    /** @test */
    public function it_requires_quanity()
    {
        $user = factory(User::class)->create();

        $product = factory(ProductVariation::class)->create();

        $this->be($user, 'api')
            ->json('PUT', "api/cart/{$product->id}")
            ->assertJsonValidationErrors([
                'quantity'
            ]);
    }

    /** @test */
    public function it_requires_quanity_to_be_numeric()
    {
        $user = factory(User::class)->create();

        $product = factory(ProductVariation::class)->create();

        $this->be($user, 'api')
            ->json('PUT', "api/cart/{$product->id}", [
                'quantity' => 'one'
            ])
            ->assertJsonValidationErrors([
                'quantity'
            ]);
    }

    /** @test */
    public function it_requires_quanity_to_be_at_least_one()
    {
        $user = factory(User::class)->create();

        $product = factory(ProductVariation::class)->create();

        $this->be($user, 'api')
            ->json('PUT', "api/cart/{$product->id}", [
                'quantity' => 0
            ])
            ->assertJsonValidationErrors([
                'quantity'
            ]);
    }

    /** @test */
    public function it_can_update_quantity()
    {
        $user = factory(User::class)->create();

        $user->cart()->attach(
            $product = factory(ProductVariation::class)->create(),
            [
                'quantity' => 1
            ]
        );

        $this->be($user, 'api')
            ->json('PUT', "api/cart/{$product->id}", [
                'quantity' => $quantity = 2
            ]);

        $this->assertDatabaseHas('cart_user', [
            'product_variation_id' => $product->id,
            'user_id' => $user->id,
            'quantity' => $quantity
        ]);
    }
}

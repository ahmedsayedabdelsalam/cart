<?php

namespace Tests\Feature\Cart;

use App\Models\ProductVariation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CartDestroyTest extends TestCase
{
    /** @test */
    public function it_fails_if_unauthenticated()
    {
        $this->json('DELETE', 'api/cart/1')
            ->assertStatus(401);
    }

    /** @test */
    public function it_fails_if_product_can_not_be_found()
    {
        $user = factory(User::class)->create();

        $this->be($user, 'api')
            ->json('DELETE', 'api/cart/1')
            ->assertStatus(404);
    }

    /** @test */
    public function it_can_delete_quantity()
    {
        $user = factory(User::class)->create();

        $user->cart()->attach(
            $product = factory(ProductVariation::class)->create(),
            [
                'quantity' => $quantity = 1
            ]
        );

        $this->be($user, 'api')
            ->json('DELETE', "api/cart/{$product->id}");

        $this->assertDatabaseMissing('cart_user', [
            'product_variation_id' => $product->id,
            'user_id' => $user->id,
            'quantity' => $quantity
        ]);
    }
}

<?php

namespace Tests\Feature\Cart;

use App\Models\ProductVariation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CartStoreTest extends TestCase
{
    /** @test */
    public function it_fails_if_unauthenticated()
    {
        $this->json('post', 'api/cart')
            ->assertStatus(401);
    }

    /** @test */
    public function it_requires_products()
    {
        $user = factory(User::class)->create();

        $this->be($user, 'api')
            ->json('post', 'api/cart')
            ->assertJsonValidationErrors(['products']);
    }

    /** @test */
    public function it_requires_products_to_be_an_array()
    {
        $user = factory(User::class)->create();

        $this->be($user, 'api')
            ->json('post', 'api/cart', [
                'products' => 1
            ])
            ->assertJsonValidationErrors(['products']);
    }

    /** @test */
    public function it_requires_products_to_have_an_id()
    {
        $user = factory(User::class)->create();

        $this->be($user, 'api')
            ->json('post', 'api/cart', [
                'products' => [
                    [
                        'quantity' => 1
                    ]
                ]
            ])
            ->assertJsonValidationErrors(['products.0.id']);
    }

    /** @test */
    public function it_requires_products_to_exists()
    {
        $user = factory(User::class)->create();

        $this->be($user, 'api')
            ->json('post', 'api/cart', [
                'products' => [
                    [
                        'id' => 1
                    ]
                ]
            ])
            ->assertJsonValidationErrors(['products.0.id']);
    }

    /** @test */
    public function it_requires_quantity_to_be_numeric()
    {
        $user = factory(User::class)->create();

        $this->be($user, 'api')
            ->json('post', 'api/cart', [
                'products' => [
                    [
                        'quantity' => 'one'
                    ]
                ]
            ])
            ->assertJsonValidationErrors(['products.0.quantity']);
    }

    /** @test */
    public function it_requires_quantity_to_be_at_least_one()
    {
        $user = factory(User::class)->create();

        $this->be($user, 'api')
            ->json('post', 'api/cart', [
                'products' => [
                    [
                        'quantity' => 0
                    ]
                ]
            ])
            ->assertJsonValidationErrors(['products.0.quantity']);
    }

    /** @test */
    public function it_can_add_products_to_user_cart()
    {
        $user = factory(User::class)->create();

        $product = factory(ProductVariation::class)->create();

        $this->be($user, 'api')
            ->json('post', 'api/cart', [
                'products' => [
                    [
                        'id' => $product->id,
                        'quantity' => $quantity = 1
                    ]
                ]
            ]);

        $this->assertDatabaseHas('cart_user', [
            'product_variation_id' => $product->id,
            'user_id' => $user->id,
            'quantity' => $quantity
        ]);
    }
}

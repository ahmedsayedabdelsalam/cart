<?php

namespace Tests\Unit\Cart;

use App\Cart\Cart;
use App\Models\ProductVariation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CartTest extends TestCase
{
    /** @test */
    public function it_can_add_products_to_the_cart()
    {
        $cart = new Cart(
            $user = factory(User::class)->create()
        );

        $product = factory(ProductVariation::class)->create();

        $cart->add([
            [
                'id' => $product->id,
                'quantity' => 1
            ]
        ]);

        $this->assertCount(1, $user->fresh()->cart);
    }

    /** @test */
    public function it_increments_quantity_when_adding_more_products()
    {
        $product = factory(ProductVariation::class)->create();

        $cart = new Cart(
            $user = factory(User::class)->create()
        );

        $cart->add([
            [
                'id' => $product->id,
                'quantity' => 1
            ]
        ]);

        $cart = new Cart($user->fresh());

        $cart->add([
            [
                'id' => $product->id,
                'quantity' => 1
            ]
        ]);

        $this->assertEquals(2, $user->fresh()->cart->first()->pivot->quantity);
    }

    /** @test */
    public function it_can_update_quantities_in_the_cart()
    {
        $cart = new Cart(
            $user = factory(User::class)->create()
        );

        $user->cart()->attach(
            $product = factory(ProductVariation::class)->create()
        );

        $cart->update($product->id, 2);

        $this->assertEquals(2, $user->fresh()->cart->first()->pivot->quantity);
    }

    /** @test */
    public function it_can_delete_a_product_from_the_cart()
    {
        $cart = new Cart(
            $user = factory(User::class)->create()
        );

        $user->cart()->attach(
            $product = factory(ProductVariation::class)->create()
        );

        $cart->delete($product->id);

        $this->assertCount(0, $user->fresh()->cart);
    }

    /** @test */
    public function it_can_empty_the_cart()
    {
        $cart = new Cart(
            $user = factory(User::class)->create()
        );

        $user->cart()->attach(
            $product = factory(ProductVariation::class)->create()
        );

        $cart->empty();

        $this->assertCount(0, $user->fresh()->cart);
    }
}

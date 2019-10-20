<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use Tests\TestCase;

class ProductShowTest extends TestCase
{
    /** @test */
    public function it_fails_if_a_product_cant_be_found()
    {
        $this->get('api/products/not-found-product')
            ->assertStatus(404);
    }

    /** @test */
    public function it_show_a_product()
    {
        $product = factory(Product::class)->create();
        $this->get("api/products/$product->slug")
            ->assertJsonFragment([
                'id' => $product->id
            ]);
    }
}

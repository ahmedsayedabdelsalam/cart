<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use Tests\TestCase;

class ProductIndexTest extends TestCase
{
    /** @test */
    public function it_shows_a_collection_of_products()
    {
        $product = factory(Product::class)->create();

        $this->json('GET', 'api/products')
            ->assertJsonFragment([
                'id' => $product->id,
            ]);
    }

    /** @test */
    public function it_has_paginated_data()
    {
        $this->json('GET', 'api/products')
            ->assertJsonStructure([
                'links',
            ]);
    }
}

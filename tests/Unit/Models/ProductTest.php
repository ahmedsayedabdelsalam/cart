<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use Tests\TestCase;
use App\Models\Product;
use App\Models\ProductVariation;

class ProductTest extends TestCase
{
    /** @test */
    public function it_has_slug_as_route_key_name()
    {
        $product = new Product;

        $this->assertEquals('slug', $product->getRouteKeyName());
    }

    /** @test */
    public function it_has_many_categories()
    {
        $product = factory(Product::class)->create();

        $product->categories()->save(
            factory(Category::class)->create()
        );

        $this->assertInstanceOf(Category::class, $product->categories->first());
    }

    /** @test */
    public function it_has_many_variations()
    {
        $product = factory(Product::class)->create();

        $product->variations()->save(
            factory(ProductVariation::class)->create()
        );

        $this->assertInstanceOf(ProductVariation::class, $product->variations->first());
    }
}

<?php

namespace Tests\Unit\Models;

use App\Cart\Money;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductVariation;

class ProductTest extends TestCase
{
    protected $product;

    protected function setUp(): void
    {
        parent::setUp();
        $this->product = factory(Product::class)->create();
    }

    /** @test */
    public function it_has_slug_as_route_key_name()
    {
        $product = new Product();

        $this->assertEquals('slug', $product->getRouteKeyName());
    }

    /** @test */
    public function it_has_many_categories()
    {
        $this->product->categories()->save(
            factory(Category::class)->create()
        );

        $this->assertInstanceOf(Category::class, $this->product->categories->first());
    }

    /** @test */
    public function it_has_many_variations()
    {
        $this->product->variations()->save(
            factory(ProductVariation::class)->create()
        );

        $this->assertInstanceOf(ProductVariation::class, $this->product->variations->first());
    }

    /** @test */
    public function it_returns_money_instance_for_the_price()
    {
        $this->assertInstanceOf(Money::class, $this->product->price);
    }

    /** @test */
    public function it_returns_a_formatted_price()
    {
        $product = factory(Product::class)->create([
            'price' => 1000
        ]);
        $this->assertEquals($product->formattedPrice, '£10.00');
    }
}

<?php

namespace Tests\Unit\Models;

use App\Cart\Money;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\Stock;
use Tests\TestCase;

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
            factory(Category::class)->make()
        );

        $this->assertInstanceOf(Category::class, $this->product->categories->first());
    }

    /** @test */
    public function it_has_many_variations()
    {
        $this->product->variations()->save(
            factory(ProductVariation::class)->make()
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
            'price' => 1000,
        ]);
        $this->assertEquals('£10.00', $product->formattedPrice);
    }

    /** @test */
    public function it_can_get_stock_count()
    {
        $this->product->variations()->save(
            $productVariation = factory(ProductVariation::class)->make()
        );

        $productVariation->stocks()->save(
            factory(Stock::class)->make([
                'quantity' => $quantitiy = 100,
            ])
        );

        $this->assertEquals($quantitiy, $this->product->stockCount());
    }

    /** @test */
    public function it_cat_check_if_its_in_stock()
    {
        $this->product->variations()->save(
            $productVariation = factory(ProductVariation::class)->make()
        );

        $productVariation->stocks()->save(
            factory(Stock::class)->make([
                'quantity' => 100,
            ])
        );

        $this->assertTrue($this->product->inStock());
    }
}

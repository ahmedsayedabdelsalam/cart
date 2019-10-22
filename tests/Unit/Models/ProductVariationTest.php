<?php

namespace Tests\Unit\Models;

use App\Cart\Money;
use Tests\TestCase;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\ProductVariationType;

class ProductVariationTest extends TestCase
{
    /** @test */
    public function it_has_one_product_variation_type()
    {
        $productVariation = factory(ProductVariation::class)->create([
            'product_variation_type_id' => factory(ProductVariationType::class)->create()->id,
        ]);

        $this->assertInstanceOf(ProductVariationType::class, $productVariation->type);
    }

    /** @test */
    public function it_belongs_to_a_product()
    {
        $productVariation = factory(ProductVariation::class)->create([
            'product_id' => factory(Product::class)->create()->id,
        ]);

        $this->assertInstanceOf(Product::class, $productVariation->product);
    }

    /** @test */
    public function it_returns_money_instance_for_the_price()
    {
        $productVariation = factory(ProductVariation::class)->create();

        $this->assertInstanceOf(Money::class, $productVariation->price);
    }

    /** @test */
    public function it_returns_a_formatted_price()
    {
        $productVariation = factory(ProductVariation::class)->create([
            'price' => 1000
        ]);

        $this->assertEquals($productVariation->formattedPrice, '£10.00');
    }

    /** @test */
    public function it_returns_the_product_price_if_price_is_null()
    {
        $product = factory(Product::class)->create();

        $productVariation = factory(ProductVariation::class)->create([
            'product_id' => $product->id,
            'price' => null
        ]);

        $this->assertEquals($product->formattedPrice, $productVariation->formattedPrice);
    }

    /** @test */
    public function it_can_check_if_the_variation_price_is_different_from_the_product_price()
    {
        $product = factory(Product::class)->create([
            'price' => 1000
        ]);

        $productVariation = factory(ProductVariation::class)->create([
            'product_id' => $product->id,
            'price' => 2000
        ]);

        $this->assertTrue($productVariation->priceVaries());
    }
}

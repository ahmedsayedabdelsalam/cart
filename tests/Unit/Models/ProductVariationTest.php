<?php

namespace Tests\Unit\Models;

use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\ProductVariationType;
use Tests\TestCase;

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
}

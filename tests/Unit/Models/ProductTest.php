<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Product;

class ProductTest extends TestCase
{
    /** @test */
    public function it_has_slug_as_route_key_name()
    {
        $product = new Product;

        $this->assertEquals('slug', $product->getRouteKeyName());
    }
}

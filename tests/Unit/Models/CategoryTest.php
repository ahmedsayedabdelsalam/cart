<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use App\Models\Product;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /** @test */
    public function it_has_children()
    {
        $category = factory(Category::class)->create();

        $category->children()->save(
            factory(Category::class)->make()
        );

        $this->assertInstanceOf(Category::class, $category->children->first());
    }

    /** @test */
    public function it_can_fetch_only_parents()
    {
        $category = factory(Category::class)->create();

        $category->children()->save(
            factory(Category::class)->make()
        );

        $this->assertEquals(1, Category::parents()->count());
    }

    /** @test */
    public function it_can_be_ordered_by_a_numbered_order()
    {
        $category = factory(Category::class)->create(['order' => 2]);
        $anotherCategory = factory(Category::class)->create(['order' => 1]);

        $this->assertEquals($anotherCategory->id, Category::ordered()->first()->id);
    }

    /** @test */
    public function it_has_many_products()
    {
        $category = factory(Category::class)->create();

        $category->products()->save(
            factory(Product::class)->make()
        );

        $this->assertInstanceOf(Product::class, $category->products->first());
    }
}

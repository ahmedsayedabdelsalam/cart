<?php

namespace Tests\Feature\Categories;

use App\Models\Category;
use Tests\TestCase;

class CategoryIndexTest extends TestCase
{
    /** @test */
    public function it_returns_a_collection_of_categories()
    {
        $categories = factory(Category::class, 2)->create();

        $this->json('GET', 'api/categories')
            ->assertJsonFragment(
                [
                    'slug' => $categories->get(0)->slug,
                ],
                [
                    'slug' => $categories->get(1)->slug,
                ]
            );
    }

    /** @test */
    public function it_returns_only_parent_categories()
    {
        $category = factory(Category::class)->create();

        $category->children()->save(
            factory(Category::class)->make()
        );

        $this->json('GET', 'api/categories')
            ->assertJsonCount(1, 'data');
    }

    /** @test */
    public function it_returns_categories_ordered_in_the_given_order()
    {
        $category = factory(Category::class)->create([
            'order' => 2,
        ]);

        $anotherCategory = factory(Category::class)->create([
            'order' => 1,
        ]);

        $response = $this->json('GET', 'api/categories');

        $response->assertSeeInOrder([
            $anotherCategory->slug, $category->slug,
        ]);
    }
}

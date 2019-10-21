<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\ProductVariationType;
use Faker\Generator as Faker;

$factory->define(ProductVariation::class, function (Faker $faker) {
    return [
        'name'       => $faker->unique()->name,
        'price'      => $faker->numberBetween(1000, 9000),
        'product_id' => function () {
            return factory(Product::class)->create()->id;
        },
        'product_variation_type_id' => factory(ProductVariationType::class)->create()->id,
    ];
});

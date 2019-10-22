<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\ProductVariation;
use App\Models\Stock;
use Faker\Generator as Faker;

$factory->define(Stock::class, function (Faker $faker) {
    return [
        'quantity'             => $faker->numberBetween(10, 1000),
        'product_variation_id' => factory(ProductVariation::class)->create()->id,
    ];
});

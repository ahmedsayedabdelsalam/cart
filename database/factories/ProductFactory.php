<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $name = $faker->unique()->name,
        'slug' => \Str::slug($name),
        'price' => $faker->numberBetween(1000, 9000),
        'description' => $faker->sentence,
    ];
});

<?php

use Faker\Generator as Faker;

$factory->define(App\Review::class, function (Faker $faker) {
    return [
    	'product_id' => App\Product::all()->random()->id,
        'customer' => App\User::all()->random()->name,
        'review' => $faker->paragraph,
        'star' => $faker->numberBetween(0, 5)
    ];
});

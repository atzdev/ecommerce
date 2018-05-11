<?php

use Faker\Generator as Faker;

$factory->define(App\Review::class, function (Faker $faker) {
    return [
    	'product_id' => App\Product::all()->random()->id,
        'user_id' => App\User::all()->random()->id,
        'review' => $faker->paragraph,
        'star' => $faker->numberBetween(0, 5)
    ];
});

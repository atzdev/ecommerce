<?php

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'detail' => $faker->paragraph,
        'price' => $faker->numberBetween(100,1000),
        'stock' => $faker->randomDigit,
        'user_id' => App\User::all()->random()->id,
        'discount' => $faker->numberBetween(2,30),
    ];
});

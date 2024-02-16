<?php

use Faker\Generator as Faker;

$factory->define(App\Review::class, function (Faker $faker) {
    return [
        'product_id' => function () {
            return \App\product::all()->random();
        },
        'customer_id' => function () {
            return \App\Customer::all()->random();
        },
        'rating' =>  $faker->numberBetween(1, 5),
        'review'=>  '"'.$faker->word.'"'
    ];
});

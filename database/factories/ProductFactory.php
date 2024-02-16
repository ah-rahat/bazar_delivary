<?php

use Faker\Generator as Faker;

$factory->define(App\product::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'slug' => $faker->slug,
        'color' => $faker->colorName,
        'price' => $faker->numberBetween(200, 1000),
        'discount'=> $faker->numberBetween(20, 100),
        'quantity' =>  $faker->numberBetween(200, 1000),
        'status' =>  1,
        'category_id' => function () {
            return \App\Category::all()->random();
        },
        'sub_category_id' => function () {
            return \App\sub_category::all()->random();
        },
        'featured_image' => 'https://eggmediacdnsg.azureedge.net/_mpimage/fresh-refined-sugar-1-kg?src=https%3A%2F%2Feggyolk.chaldal.com%2Fapi%2FPicture%2FRaw%3FpictureId%3D26692&q=low&v=1&targetSize=600&q=low&w=600',
        'gp_image_1' => 'https://eggmediacdnsg.azureedge.net/_mpimage/fresh-refined-sugar-1-kg?src=https%3A%2F%2Feggyolk.chaldal.com%2Fapi%2FPicture%2FRaw%3FpictureId%3D26692&q=low&v=1&targetSize=600&q=low&w=600',
        'gp_image_2' => 'https://eggmediacdnsg.azureedge.net/_mpimage/fresh-refined-sugar-1-kg?src=https%3A%2F%2Feggyolk.chaldal.com%2Fapi%2FPicture%2FRaw%3FpictureId%3D26692&q=low&v=1&targetSize=600&q=low&w=600',
        'gp_image_3' => 'https://eggmediacdnsg.azureedge.net/_mpimage/fresh-refined-sugar-1-kg?src=https%3A%2F%2Feggyolk.chaldal.com%2Fapi%2FPicture%2FRaw%3FpictureId%3D26692&q=low&v=1&targetSize=600&q=low&w=600',
        'gp_image_4' => 'https://eggmediacdnsg.azureedge.net/_mpimage/fresh-refined-sugar-1-kg?src=https%3A%2F%2Feggyolk.chaldal.com%2Fapi%2FPicture%2FRaw%3FpictureId%3D26692&q=low&v=1&targetSize=600&q=low&w=600',
        'user_id' => 1,
    ];
});

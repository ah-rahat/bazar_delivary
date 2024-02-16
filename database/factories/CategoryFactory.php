<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;
$factory->define(App\Category::class, function (Faker $faker) {
    return [
        'cat_name'=> $faker->word->unique(),
        'slug'=>  $slug = Str::slug($faker->word, '-'),
        'user_id'=>1
    ];
});

<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;
$factory->define(App\sub_category::class, function (Faker $faker) {
    return [
        'category_id'=> function(){
        return \App\Category::all()->random();
        },
         'sub_cat_name'=> $faker->word->unique(),
        'slug'=>  $slug = Str::slug($faker->word, '-'),
        'user_id'=>1

    ];
});

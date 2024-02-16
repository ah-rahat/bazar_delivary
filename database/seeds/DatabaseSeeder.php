<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
          //$this->call(UsersTableSeeder::class);
       // factory(App\Category::class,5)->create();
       // factory(App\sub_category::class,5)->create();
        factory(App\product::class,50)->create();
        //factory(\App\Customer::class,5)->create();
        factory(\App\Review::class,5)->create();

    }
}

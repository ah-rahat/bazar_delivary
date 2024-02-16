<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('name_bn');
            $table->string('tags');
            $table->string('slug')->unique();
            $table->float('price');
            $table->float('discount')->nullable();
            $table->string('unit');
            $table->float('unit_quantity');
            $table->float('stock_quantity');
            $table->boolean('status');
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->integer('sub_category_id')->unsigned();
            $table->foreign('sub_category_id')->references('id')->on('sub_categories')->onDelete('cascade');
             $table->integer('child_sub_cats_id')->nullable();
             $table->integer('brand_id')->unsigned();
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->string('featured_image');
            $table->string('gp_image_1')->nullable();
            $table->string('gp_image_2')->nullable();
            $table->string('gp_image_3')->nullable();
            $table->string('gp_image_4')->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}

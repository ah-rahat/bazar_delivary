<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChildSubCatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('child_sub_cats', function (Blueprint $table) {
            $table->increments('id');
            $table->string('child_cat_name')->unique();
            $table->string('child_cat_name_bn');
            $table->string('slug')->unique();
            //$table->string('image')->nullable();
            $table->integer('sub_category_id')->nullable();
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('child_sub_cats');
    }
}

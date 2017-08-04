<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
      Schema::create('categories',function(Blueprint $table) {
          $table->increments('id');
          $table->integer('parent_id')->unsigned()->nullable()->default(null);
          $table->integer('order')->default(1);
          $table->string('name');
          $table->string('slug')->unique()->nullable();
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
		//
        Schema::drop('categories');
	}

}

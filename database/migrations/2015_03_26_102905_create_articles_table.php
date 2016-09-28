<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('articles',function(Blueprint $table){

            $table->increments('id');
            $table->integer('category_id')->default(0);
            $table->integer('user_id');
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->string('pic');
            $table->text('content');
            $table->string('keywords')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();

        });

        Schema::create('article_status',function(Blueprint $table){

            $table->increments('id');
            $table->integer('article_id');
            $table->integer('views')->default(0);
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('article_status');
        Schema::drop('articles');
	}

}

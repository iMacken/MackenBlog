<?php

use Illuminate\Support\Facades\Schema;
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
            $table->integer('category_id')->unsigned()->default(0);
            $table->integer('user_id')->unsigned();
            $table->integer('last_user_id')->unsigned();
            $table->string('title')->unique();
            $table->string('subtitle');
            $table->string('slug')->unique();
            $table->string('image');
            $table->text('content');
            $table->boolean('is_original')->default(false);
            $table->boolean('is_draft')->default(false);
            $table->string('keywords')->nullable();
            $table->string('description')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->integer('view_count')->unsigned()->default(0);
            $table->timestamps();
            $table->softDeletes();

        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('articles');
	}

}

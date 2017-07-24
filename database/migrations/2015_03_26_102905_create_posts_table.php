<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('posts',function(Blueprint $table){

            $table->increments('id');
            $table->integer('category_id')->unsigned()->default(0);
            $table->integer('user_id')->unsigned();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('image')->nullable();
            $table->text('content');
	        $table->text('html_content');
            $table->string('excerpt')->nullable();
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
        Schema::drop('posts');
	}

}

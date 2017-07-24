<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUploadedFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create table for storing roles
        Schema::create('uploaded_files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onUpdate('cascade')->onDelete('set null');
            $table->text('description')->nullable();
            $table->string('path')->nullable();
            $table->string('link')->nullable();
            $table->string('mime')->nullable();
            $table->integer('order')->default(1);
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
        Schema::drop('uploaded_files');
    }
}

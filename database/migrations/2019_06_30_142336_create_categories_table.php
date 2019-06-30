<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('author_id')->unsigned()->nullable()->deafult(null);
            $table->bigInteger('parent_category_id')->unsigned()->nullable()->deafult(null);
            $table->string('title')->nullable()->deafult(null);
            $table->string('slug')->nullable()->deafult(null)->unique();
            $table->longText('description')->nullable()->deafult(null);
            $table->string('image')->nullable()->deafult(null);
            $table->boolean('is_active')->nullable()->deafult(null)->index();
            $table->timestamps();
            $table->foreign('author_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->foreign('parent_category_id')->references('id')->on('categories')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}

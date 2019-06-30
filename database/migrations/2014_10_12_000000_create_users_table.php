<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable()->deafult(null);
            $table->string('email')->nullable()->deafult(null)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable()->deafult(null);
            $table->string('api_token')->nullable()->deafult(null)->unique();
            $table->boolean('is_active')->nullable()->deafult(null)->index();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}

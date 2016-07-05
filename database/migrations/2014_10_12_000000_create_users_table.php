<?php

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
            $table->increments('id');
            $table->string('lastname', 100);
            $table->string('firstname', 100);
            $table->string('email')->unique();
            $table->string('password');
            $table->dateTime('last_connect');
            $table->rememberToken();
            $table->boolean('spam');
            $table->foreign('coordinate_id')->references('id')->on('coordinates');
            $table->foreign('role_id')->references('id')->on('roles');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}

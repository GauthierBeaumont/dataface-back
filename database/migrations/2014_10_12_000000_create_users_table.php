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
            $table->boolean('email_valide');
            $table->string('password');
            $table->dateTime('last_connect');
            $table->rememberToken();
            $table->boolean('spam');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
            $table->integer('coordinate_id')->unsigned();
            $table->integer('role_id')->unsigned();
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
    }
}

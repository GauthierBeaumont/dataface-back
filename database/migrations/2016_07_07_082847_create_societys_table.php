<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocietysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('societys', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->longText('presentation');
            $table->longText('mentionLegal');
            $table->longText('cgv');
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
        Schema::drop('societys');
    }
}

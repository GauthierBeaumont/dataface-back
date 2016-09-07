<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionsTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('subscriptions_types', function (Blueprint $table) {
          $table->increments('id')->unsigned();
          $table->decimal('price',10,2);
          $table->string('name');
          $table->integer('duration_month');
          $table->longText('Description')->nullable();
          $table->integer('order'); // soit 1 ou 0
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
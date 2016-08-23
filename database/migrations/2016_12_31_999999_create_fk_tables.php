<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFkTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('coordinate_id')->onDelete('cascade')->references('id')->on('coordinates');
            $table->foreign('role_id')->references('id')->on('roles');
        });

        Schema::table('user_applications', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('application_id')->references('id')->on('applications');
        });

        Schema::table('user_subscriptions', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('user_subscription_id')->references('id')->on('subscriptions');
        });

        Schema::table('user_payments', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('type_payment_id')->references('id')->on('type_payments');
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

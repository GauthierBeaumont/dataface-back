<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class DeleteTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::drop('user_applications');
        Schema::drop('user_subscriptions');
        Schema::drop('applications');
        Schema::drop('subscriptions');
        Schema::drop('subscriptions_types');
        Schema::drop('type_payments');
        Schema::drop('password_resets');
        Schema::drop('users');
        Schema::drop('roles');
        Schema::drop('coordinates');
        Schema::drop('societies');



    }
}
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
            $table->foreign('coordinate_id')->references('id')->on('coordinates');
            $table->foreign('role_id')->references('id')->on('roles');
        });
        Schema::table('user_applications', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('application_id')->references('id')->on('applications');
        });
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->foreign('subscriptions_types_id')->references('id')->on('subscriptions_types');
            $table->foreign('type_payments_id')->references('id')->on('type_payments');
        });
        Schema::table('user_subscriptions', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('subscription_id')->references('id')->on('subscriptions');
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
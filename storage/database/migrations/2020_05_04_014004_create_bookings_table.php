<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('duoDate');
            $table->time('duoTime');
            $table->string('refCode');
            $table->double('subTotal')->nullable();
            $table->double('discount')->nullable();
            $table->double('totalAmount')->nullable();
            $table->tinyInteger('paidStatus')->unsigned()->nullable();
            $table->tinyInteger('paymentWays')->unsigned()->nullable();
            $table->tinyInteger('status')->unsigned()->nullable();
            $table->tinyInteger('serviceType')->unsigned()->nullable();
            $table->bigInteger('userId')->unsigned()->nullable();
            $table->bigInteger('serviceId')->unsigned()->nullable();
            $table->bigInteger('couponId')->unsigned()->nullable();
            $table->bigInteger('parentId')->unsigned()->nullable();
            $table->bigInteger('locationId')->unsigned()->nullable();
            $table->bigInteger('providerId')->unsigned()->nullable();
            $table->bigInteger('scheduleId')->unsigned()->nullable();
            $table->foreign('userId')->references('id')->on('users')->onDelete('set null');
            $table->foreign('couponId')->references('id')->on('coupons')->onDelete('set null');
            $table->foreign('parentId')->references('id')->on('bookings')->onDelete('set null');
            $table->foreign('locationId')->references('id')->on('user_locations')->onDelete('set null');
            $table->foreign('providerId')->references('id')->on('providers')->onDelete('set null');
            $table->foreign('scheduleId')->references('id')->on('schedules')->onDelete('set null');

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
        Schema::dropIfExists('bookings');
    }
}

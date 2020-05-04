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
            $table->dateTime('duoDate');
            $table->double('price');
            $table->double('discount');
            $table->double('totalAmount');
            $table->enum('status',['Pending','Confirm','Canceled']);
            $table->bigInteger('userId')->unsigned();
            $table->bigInteger('serviceId')->unsigned();
            $table->bigInteger('couponId')->unsigned()->nullable();
            $table->foreign('userId')->references('id')->on('users');
            $table->foreign('serviceId')->references('id')->on('services');
            $table->foreign('couponId')->references('id')->on('coupons');
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('answerValue')->nullable();
            $table->integer('count')->nullable();
            $table->double('itemPrice')->nullable();
            $table->double('totalAmount')->nullable();
            $table->bigInteger('answerId')->nullable()->unsigned();
            $table->bigInteger('questionId')->unsigned()->nullable();
            $table->bigInteger('bookingId')->unsigned();
            $table->foreign('answerId')->references('id')->on('question_details')->onDelete('set null');
            $table->foreign('questionId')->references('id')->on('questions')->onDelete('set null');
            $table->foreign('bookingId')->references('id')->on('bookings')
            ->onDelete('cascade');
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
        Schema::dropIfExists('booking_answers');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('starCount');
            $table->bigInteger('userId')->unsigned();
            $table->bigInteger('serviceProviderId')->unsigned();
            $table->bigInteger('bookingId')->unsigned();
            $table->foreign('userId')->references('id')->on('users');
            $table->foreign('serviceProviderId')->references('id')->on('service_providers');
            $table->foreign('bookingId')->references('id')->on('bookings');
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
        Schema::dropIfExists('evaluations');
    }
}

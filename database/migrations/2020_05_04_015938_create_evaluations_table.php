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
            $table->bigInteger('userId')->unsigned()->nullable();
            $table->bigInteger('serviceProviderId')->unsigned()->nullable();
            $table->bigInteger('bookingId')->unsigned();
            $table->foreign('userId')->references('id')->on('users')->onDelete('set null');;
            $table->foreign('serviceProviderId')->references('id')->on('service_providers')->onDelete('set null');
            $table->foreign('bookingId')->references('id')->on('bookings')->onDelete('cascade');
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

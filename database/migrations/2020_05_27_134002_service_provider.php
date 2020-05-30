<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ServiceProvider extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providerServices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('serviceId')->unsigned();
            $table->bigInteger('providerId')->unsigned();
            $table->foreign('serviceId')->references('id')->on('services')
                ->onDelete('cascade');
            $table->foreign('providerId')->references('id')->on('providers')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('providerServices');
    }
}

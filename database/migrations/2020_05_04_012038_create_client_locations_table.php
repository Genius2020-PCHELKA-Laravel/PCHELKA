<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_locations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('address');
            $table->double('lat');
            $table->double('lon');
            $table->string('details');
            $table->string('area');
            $table->string('street');
            $table->integer('buildingNumber');
            $table->string('apartment');
            $table->bigInteger('clientId')->unsigned();
            $table->foreign('clientId')->references('id')->on('clients');
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
        Schema::dropIfExists('client_locations');
    }
}

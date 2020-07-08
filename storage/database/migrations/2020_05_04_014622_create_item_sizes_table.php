<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_sizes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('serviceType',['CarpetCleaning','BlindsCleaning']);
            $table->integer('itemNum');
            $table->double('itemSizeX');
            $table->double('itemSizeY');
            $table->double('priceOfSm');
            $table->bigInteger('bookingId')->unsigned();
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
        Schema::dropIfExists('item_sizes');
    }
}

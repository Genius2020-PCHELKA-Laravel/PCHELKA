<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('details')->nullable();
            $table->string('imgPath');
            $table->tinyInteger('type')->nullable();
            $table->bigInteger('couponId')->unsigned()->nullable();
            $table->integer('orderNumber');
            $table->string('unit');
            $table->foreign('couponId')->references('id')->on('coupons')->onDelete('set null');
            $table->timestamps();
            $table->double('materialPrice');
            $table->double('hourPrice');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
}

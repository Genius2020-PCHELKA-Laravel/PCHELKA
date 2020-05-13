<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('serviceId')->unsigned();
            $table->bigInteger('questionId')->unsigned();
            $table->foreign('serviceId')->references('id')->on('services')->onDelete('cascade');
            $table->foreign('questionId')->references('id')->on('questions');
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
        Schema::dropIfExists('services_questions');
    }
}

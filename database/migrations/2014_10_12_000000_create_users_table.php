<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fullName')->nullable();
            $table->string('email')->unique()->nullable();
            $table->bigInteger('mobile')->unique();
            $table->timestamp('mobile_verified_at')->nullable();
            $table->integer('isVerified'); 
            $table->string('password')->nullable();
            $table->date('dateOfBirth')->nullable();
            $table->enum('gender',['Male','Female'])->nullable();
            $table->enum('language',['Ar','En'])->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}

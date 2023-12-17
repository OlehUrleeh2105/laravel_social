<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableUserFollowers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_followers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('origin_user');
            $table->unsignedBigInteger('follow_to');
            $table->timestamps();
            $table->foreign('origin_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('follow_to')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_followers');
    }
}

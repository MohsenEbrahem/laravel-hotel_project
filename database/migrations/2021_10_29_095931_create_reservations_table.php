<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('guestNumber')->unsigned();
            $table->foreign('guestNumber')->references('id')->on('guests');
            $table->bigInteger('roomNumber')->unsigned();
            $table->foreign('roomNumber')->references('id')->on('rooms');
            $table->Date('incomeDate');
            $table->Date('exitDate');
            $table->double('reservationCost');
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
        Schema::dropIfExists('reservations');
    }
}

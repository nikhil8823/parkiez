<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ParkingBookingDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('parking_id');
            $table->string('slot_id');
            $table->text('car_number');
            $table->integer('cost')->nullable();
            $table->dateTime('in_time');
            $table->dateTime('out_time')->nullable();
            $table->string('payment_mode')->default(0);
            $table->integer('status')->default(0)->comment('0 : Available, 1: Booked, 2: History');
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
        Schema::dropIfExists('booking_details');
    }
}

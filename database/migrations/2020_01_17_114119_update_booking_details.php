<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateBookingDetails extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('booking_details', function(Blueprint $table) {
            $table->string('mobile_number')->nullable()->after('payment_mode');
            $table->boolean('in_sms_status')->default(0)->comment('0 : Not Send, 1: Send, 2: Failed');
            $table->boolean('out_sms_status')->default(0)->comment('0 : Not Send, 1: Send, 2: Failed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
    }

}

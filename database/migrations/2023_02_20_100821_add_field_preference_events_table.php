<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldPreferenceEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->integer('early_cost')->nullable();
            $table->date('early_cost_before')->nullable();
            $table->integer('regular_cost')->nullable();
            $table->integer('minimum_prepayment_percent')->nullable();
            $table->date('booking_without_payment_before')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

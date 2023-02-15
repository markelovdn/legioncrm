<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldSertifnumOrgidAthleteTehvalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('athlete_tehkval', function (Blueprint $table) {
            $table->integer('organization_id');
            $table->string('sertificatenum', 45)->nullable();
            $table->string('sertificate_link', 300)->nullable();
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

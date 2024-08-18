<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompetitorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competitors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('athlete_id')->constrained('athletes');
            $table->double('weight');
            $table->integer('lot')->nullable();
            $table->foreignId('agecategory_id')->nullable()->constrained('age_categories');
            $table->foreignId('weightcategory_id')->nullable()->constrained('weight_categories');
            $table->foreignId('tehkvalgroup_id')->nullable()->constrained('tehkvals_groups');
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
        Schema::dropIfExists('competitors');
    }
}

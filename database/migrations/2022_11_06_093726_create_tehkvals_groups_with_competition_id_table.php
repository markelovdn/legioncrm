<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTehkvalsGroupsWithCompetitionIdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tehkvals_groups', function (Blueprint $table) {
            $table->foreignId('competition_id')->nullable()->constrained('competitions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tehkvals_groups_with_competition_id');
    }
}

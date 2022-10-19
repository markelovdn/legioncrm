<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTehkvalsGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tehkvals_groups', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('startgyp_id')->nullable()->constrained('tehkvals');
            $table->foreignId('finishgyp_id')->nullable()->constrained('tehkvals');
            $table->foreignId('agecategory_id')->nullable()->constrained('age_categories');
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
        Schema::dropIfExists('tehkvals_groups');
    }
}

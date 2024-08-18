<?php

use App\Models\Coach;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAthleteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('athletes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->integer('gender')->nullable();
            $table->string('photo', 256)->nullable();
            $table->integer('status')->nullable();
            $table->foreignId('studyplace_id')->nullable()->constrained('study_places');
            $table->foreignId('passport_id')->nullable()->constrained('passports');
            $table->foreignId('birthcertificate_id')->nullable()->constrained('birth_certificates');
            $table->foreignId('snils_id')->nullable()->constrained('snils');
            $table->foreignId('medicalpolicy_id')->nullable()->constrained('medical_policies');
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
        Schema::dropIfExists('athletes');
    }
}

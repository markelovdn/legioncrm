<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationsTableWithoutUserId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organizations', function (Blueprint $table) {

            $orgs = DB::table('organizations')
                ->where('user_id', '!=', null)
                ->get(['*']);

            foreach ($orgs as $org) {
                DB::table('organization_user')->insert([
                    ['organization_id' => $org->id, 'user_id' => $org->user_id,]
                ]);

                DB::table('organizations')
                    ->where('id', '!=', null)
                    ->update(['user_id' => null]);
            }
            $table->dropConstrainedForeignId('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organizations_table_without_user_id');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersTableWithoutRoleId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        $users = DB::table('users')
            ->where('role_id', '!=', null)
            ->get(['*']);

            foreach ($users as $user) {
                DB::table('role_user')->insert([
                    ['role_id' => $user->role_id, 'user_id' => $user->id,]
                ]);
            }

        Schema::table('users', function (Blueprint $table) {
            if (DB::getDriverName() !== 'sqlite') {
                $table->dropForeign(['role_id']);
            }
            $table->dropColumn('role_id');
        });

        }





    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}

<?php


namespace App\BusinessProcess;


use App\Models\Athlete;
use App\Models\Coach;
use App\Models\Parented;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class GetCompetitiors
{
    public function getCompetitors (int $id)
    {
        $coach = Coach::where('user_id', $id)->first();
        $parented = Parented::where('user_id', $id)->first();

        if ($coach) {
            if(DB::table('athlete_coach')->where('coach_id', $coach->id)->get()) {
                return Athlete::with('coaches', 'user', 'tehkval', 'sportkval')->has('coaches')->get();
            } else
                return false;
        }

        if ($parented) {
            if(DB::table('athlete_parented')->where('parented_id', $parented->id)->get()) {
                return Athlete::with('parenteds', 'coaches', 'user', 'tehkval', 'sportkval')->has('parenteds')->get();
            } else
                return false;
        }
    }


}

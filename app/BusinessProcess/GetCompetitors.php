<?php


namespace App\BusinessProcess;


use App\Filters\UserFilter;
use App\Models\Athlete;
use App\Models\Coach;
use App\Models\Parented;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class GetCompetitors
{
    public function getCompetitors (int $id)
    {

        $coach = Coach::where('user_id', $id)->first();
        $parented = Parented::where('user_id', $id)->first();

        if ($coach) {
            $coach_athletes = DB::table('athlete_coach')->where('coach_id', $coach->id)->get();

            if($coach_athletes) {
                $athletes = [];
                foreach ($coach_athletes as $item) {
                    $athletes[] = $item->athlete_id;
                }

                return Athlete::with('coaches', 'user', 'tehkval', 'sportkval')
                    ->whereIn('id', $athletes)->get();
            } else
                return false;
        }

        if ($parented) {
            $parented_athletes = DB::table('athlete_parented')->where('parented_id', $parented->id)->get();
            if($parented_athletes) {
                $athletes = [];
                foreach ($parented_athletes as $item) {
                    $athletes[] = $item->athlete_id;
                }

                return Athlete::with('coaches', 'user', 'tehkval', 'sportkval')
                    ->whereIn('id', $athletes)->get();
            } else
                return false;
        }
    }

    public function allCompetitors ($user) {

        return User::filter($user)->orderBy('secondname')->paginate(10);
    }
}

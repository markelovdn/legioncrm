<?php


namespace App\BusinessProcess;


use App\Models\Athlete;
use App\Models\Coach;
use App\Models\Parented;
use App\Models\Tehkval;
use Illuminate\Support\Facades\DB;

class GetEventUsers
{
    public function getUsers (int $id)
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

    public function getNextTehkval (int $athlete_id) {
        $athlete = Athlete::where('id', $athlete_id)->with('tehkval')->first();
        $nextTehkval = Tehkval::where('id',$athlete->tehkval->last()->id+1)->first();

        return $nextTehkval->title;
    }
}

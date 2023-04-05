<?php


namespace App\DomainService;


use App\Models\Coach;
use App\Models\Competition;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Builder;

class GetCoachesCompetition
{
    public function __invoke()
    {
        $competition_id = Request::route()->parameter('competition_id');

        $competition = Competition::where('id', $competition_id)->first();
        $competitors = $competition->competitors()->get();

        $athlete_id = [];
        foreach ($competitors as $competitor) {
            $athlete_id[] = $competitor->athlete_id;
        }

        $coach_athlete = DB::table('athlete_coach')
            ->where('coach_type', Coach::REAL_COACH)
            ->whereIn('athlete_id', $athlete_id)->get();

        $coach_id = [];

        foreach ($coach_athlete as $coach) {
            $coach_id[] = $coach->coach_id;
        }

        return Coach::with('user')->whereIn('id', $coach_id)->get();
    }
}

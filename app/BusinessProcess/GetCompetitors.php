<?php


namespace App\BusinessProcess;


use App\Filters\UserFilter;
use App\Models\Athlete;
use App\Models\Coach;
use App\Models\Competition;
use App\Models\Competitor;
use App\Models\Parented;
use App\Models\Referee;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GetCompetitors
{
    public function getCompetitors (int $id, $competition_id, $CompetitorFilter, $weightFilter, $athleteFilter)
    {
        $competition = Competition::where('id', $competition_id)->first();
        $coach = Coach::where('user_id', $id)->first();
        $parented = Parented::where('user_id', $id)->first();
        $referee = Referee::where('user_id', $id)->first();

        if ($coach) {
            if(Str::contains(url()->current(), 'create')) {
                $competitors = $coach->athletes()
                    ->wherePivot('coach_type', '=', Coach::REAL_COACH)
                    ->with('user', 'tehkval', 'sportkval')
                    ->orderBy(function ($query) { 
                        $query->select('secondname')->from('users')->whereColumn('users.id', 'athletes.user_id')->limit(1);
                    })
                    ->get();

                return $competitors;
            }

            $athletes = Athlete::with('coaches', 'user', 'tehkval', 'sportkval')
                ->filter($athleteFilter)->get();

            if($athletes != null && $athletes->count() >= 1) {
                foreach ($athletes as $athlete_coach) {
                    $ids[] = $athlete_coach->id;
                }
                $competitors = $competition->competitors()
                    ->with('athlete', 'agecategory', 'weightcategory', 'tehkvalgroup')
                    ->whereIn('athlete_id', $ids)
                    ->join('users', 'athletes.user_id', '=', 'users.id')
                    ->orderBy('users.secondname')
                    ->filter($CompetitorFilter)->get();
            }

            return $competitors;
        }

        if ($parented) {
            if(Str::contains(url()->current(), 'create')) {
                $competitors = Athlete::with('coaches', 'user', 'tehkval', 'sportkval')
                    ->whereHas('parenteds', function (Builder $query) use ($parented) {
                        $query->where('parented_id', '=', $parented->id);
                    })->get();

                return $competitors;
            }

            $parented_athletes = DB::table('athlete_parented')->where('parented_id', $parented->id)->get();
            if($parented_athletes) {
                $athletes = [];
                foreach ($parented_athletes as $item) {
                    $athletes[] = $item->athlete_id;
                }

                $athletes_parent = Athlete::with('coaches', 'user', 'tehkval', 'sportkval')
                    ->whereIn('id', $athletes)->get();

                if($athletes_parent != null && $athletes_parent->count() >= 1) {
                    foreach ($athletes_parent as $athlete_parent) {
                        $ids[] = $athlete_parent->id;
                    }

                    $competitors = $competition->competitors()
                        ->with('athlete', 'agecategory', 'weightcategory', 'tehkvalgroup')
                        ->whereIn('athlete_id', $ids)->get();

                    if ($competitors->count() == 0) {
                        return false;
                    }

                    return $competitors;
                }

            } else
                return false;
        }

        if (Competition::getOwner($competition_id) || $referee) {
            if(Str::contains(url()->current(), 'create')) {
                return false;
            }

            $competitors = Athlete::with('coaches', 'user', 'tehkval', 'sportkval')
                ->filter($athleteFilter)->get();

            if($competitors != null && $competitors->count() >= 1) {
                foreach ($competitors as $athlete) {
                    $ids[] = $athlete->id;
                }
                $competitors = $competition->competitors()
                    ->with('athlete', 'agecategory', 'weightcategory', 'tehkvalgroup')
                    ->whereIn('athlete_id', $ids)
                    ->filter($CompetitorFilter)->get();
            }

            return $competitors;
        }

    }

    public function getCompetitorsApi ($CompetitorFilter, $athleteFilter)
    {
        $competition = Competition::where('id', $CompetitorFilter->request->query('competition_id'))->first();
        $coach = Coach::where('user_id', \auth()->user()->id)->first();
        $parented = Parented::where('user_id', \auth()->user()->id)->first();
        $referee = Referee::where('user_id', \auth()->user()->id)->first();

        if ($parented) {
            if(Str::contains(url()->current(), 'create')) {
                $competitors = Athlete::with('coaches', 'user', 'tehkval', 'sportkval')
                    ->whereHas('parenteds', function (Builder $query) use ($parented) {
                        $query->where('parented_id', '=', $parented->id);
                    })->get();

                return $competitors;
            }

            $parented_athletes = DB::table('athlete_parented')->where('parented_id', $parented->id)->get();
            if($parented_athletes) {
                $athletes = [];
                foreach ($parented_athletes as $item) {
                    $athletes[] = $item->athlete_id;
                }

                $athletes_parent = Athlete::with('coaches', 'user', 'tehkval', 'sportkval')
                    ->whereIn('id', $athletes)->get();

                if($athletes_parent != null && $athletes_parent->count() >= 1) {
                    foreach ($athletes_parent as $athlete_parent) {
                        $ids[] = $athlete_parent->id;
                    }

                    $competitors = $competition->competitors()
                        ->with('athlete', 'agecategory', 'weightcategory', 'tehkvalgroup')
                        ->whereIn('athlete_id', $ids)->get();

                    if ($competitors->count() == 0) {
                        return false;
                    }

                    return $competitors;
                }

            } else
                return false;
        }

        if(Str::contains(url()->current(), 'create')) {
                $competitors = Athlete::with('coaches', 'user', 'tehkval', 'sportkval')
                    ->whereHas('coaches', function (Builder $query) use ($coach) {
                        $query->where('coach_id', '=', $coach->id)
                            ->where('coach_type', '=', Coach::REAL_COACH);
                    })->join('users', 'athletes.user_id', '=', 'users.id')
                    ->orderBy('users.secondname')->get();

                return $competitors;
            }

//        if (Str::contains(url()->current(), 'create') && Competition::getOwner($CompetitorFilter->request->query('competition_id')) || $referee) {
//            return false;
//        }

        $competitors = Competitor::whereRelation('competitions', 'competition_id', $competition->id)
            ->with('athlete','agecategory', 'weightcategory', 'tehkvalgroup')
            ->join('athletes', 'competitors.athlete_id', '=', 'athletes.id')
            ->join('users', 'athletes.user_id', '=', 'users.id')
            ->orderBy('users.secondname')
            ->filter($CompetitorFilter)
            ->get();

        return $competitors;

    }

    public function allCompetitors ($user) {

        return User::filter($user)->orderBy('secondname')->paginate(10);
    }
}

<?php


namespace App\BusinessProcess;


use App\Filters\UserFilter;
use App\Models\Athlete;
use App\Models\Coach;
use App\Models\Competition;
use App\Models\Parented;
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

        if ($coach) {
            if(Str::contains(url()->current(), 'create')) {
                $competitors = Athlete::with('coaches', 'user', 'tehkval', 'sportkval')
                    ->whereHas('coaches', function (Builder $query) use ($coach) {
                        $query->where('coach_id', '=', $coach->id)
                            ->where('coach_type', '=', Coach::REAL_COACH);
                    })->get();

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
                    ->whereIn('athlete_id', $ids)->get();
            }

            return $competitors;
        }

        if (Competition::getOwner($competition_id)) {
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
                    ->whereIn('athlete_id', $ids)->get();
            }

            return $competitors;
        }

    }

    public function allCompetitors ($user) {

        return User::filter($user)->orderBy('secondname')->paginate(10);
    }
}

//
//if ($coach) {
//    $coach_athletes = DB::table('athlete_coach')->where('coach_id', $coach->id)->where('coach_type', Coach::REAL_COACH)->get();
//
//    if($coach_athletes) {
//        $athletes = [];
//        foreach ($coach_athletes as $item) {
//            $athletes[] = $item->athlete_id;
//        }
//
//        $a = Athlete::with('coaches', 'user', 'tehkval', 'sportkval')
//            ->whereIn('id', $athletes)->get();
//
//        return Athlete::with('coaches', 'user', 'tehkval', 'sportkval')
//            ->whereIn('id', $athletes)->get();
//    } else
//        return false;
//}
//
//if ($parented) {
//    $parented_athletes = DB::table('athlete_parented')->where('parented_id', $parented->id)->get();
//    if($parented_athletes) {
//        $athletes = [];
//        foreach ($parented_athletes as $item) {
//            $athletes[] = $item->athlete_id;
//        }
//
//        return Athlete::with('coaches', 'user', 'tehkval', 'sportkval')
//            ->whereIn('id', $athletes)->get();
//    } else
//        return false;
//}
//
//if ($athletes_parent == null && $user->isParented($user) ||
//    $athletes_parent != null && $user->isParented($user) && $athletes_parent->count() < 1) {
//    session()->flash('status', 'Вы не добавляли спортсменов на данное мероприятие');
//    return view('competitions.competitors',
//        ['competition'=>$competition, 'competitors'=>$competitors, 'tehkvals'=>$tehkvals]);
//}
//
//if($athletes_parent != null && $athletes_parent->count() >= 1 && $user->isParented($user)) {
//    foreach ($athletes_parent as $athlete_parent) {
//        $ids[] = $athlete_parent->id;
//    }
//    $competitors = $competition->competitors()
//        ->with('athlete', 'agecategory', 'weightcategory', 'tehkvalgroup')
//        ->whereIn('athlete_id', $ids)
//        ->get();
//
//    if($competitors->count() < 1) {
//        session()->flash('status', 'Вы не добавляли спортсменов на данное мероприятие');
//        return view('competitions.competitors', ['competition'=>$competition, 'competitors'=>$competitors]);
//    }
//    return view('competitions.competitors', ['competition'=>$competition, 'competitors'=>$competitors, 'tehkvals'=>$tehkvals]);
//}
//
//$competitors = $competition->competitors()
//    ->with('athlete', 'agecategory', 'weightcategory', 'tehkvalgroup')
//    ->orderBy('id', 'DESC')
//    ->get();

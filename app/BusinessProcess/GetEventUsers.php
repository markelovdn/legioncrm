<?php


namespace App\BusinessProcess;


use App\Models\Athlete;
use App\Models\Coach;
use App\Models\Event;
use App\Models\Parented;
use App\Models\Role;
use App\Models\Tehkval;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GetEventUsers
{
    public function getUsers (int $id, $event_id, $athleteFilter)
    {
        $event = Event::where('id', $event_id)->first();
        $coach = Coach::where('user_id', $id)->first();
        $parented = Parented::where('user_id', $id)->first();

        if ($parented) {
            if(Str::contains(url()->current(), 'create')) {
                $users = Athlete::with('coaches', 'user', 'tehkval', 'sportkval')
                    ->whereHas('parenteds', function (Builder $query) use ($parented) {
                        $query->where('parented_id', '=', $parented->id);
                    })->get();

                return $users;
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
                        $ids[] = $athlete_parent->user_id;
                    }

                    $users = $event->users()->whereIn('user_id', $ids)->get();

                    if ($users->count() == 0) {
                        return false;
                    }

                    return $users;
                }

            } else
                return false;
        }

        if ($coach) {
            if(Str::contains(url()->current(), 'create')) {
                $users = Athlete::with('coaches', 'user', 'tehkval', 'sportkval')
                    ->whereHas('coaches', function (Builder $query) use ($coach) {
                        $query->where('coach_id', '=', $coach->id)
                            ->where('coach_type', '=', Coach::REAL_COACH);
                    })->get();

                return $users;
            }

            $users = Athlete::with('coaches', 'user', 'tehkval', 'sportkval')
                ->filter($athleteFilter)->get();

            if($users != null && $users->count() >= 1) {
                foreach ($users as $athlete_coach) {
                    $ids[] = $athlete_coach->user_id;
                }
                $users = $event->users()->whereIn('user_id', $ids)->orderBy('secondname', 'ASC')->get();
            }

            return $users;
        }

        if (Event::getOwner($event_id)) {
            if(Str::contains(url()->current(), 'create')) {
                return false;
            }

            $users = Athlete::with('coaches', 'user', 'tehkval', 'sportkval')
                ->filter($athleteFilter)->get();

            if($users != null && $users->count() >= 1) {
                foreach ($users as $athlete) {
                    $ids[] = $athlete->user_id;
                }
                $users = $event->users()->whereIn('user_id', $ids)->orderBy('secondname', 'ASC')->get();
            }

            return $users;
        }

    }

    public function getNextTehkval (int $athlete_id) {
        $athlete = Athlete::where('id', $athlete_id)->with('tehkval')->first();
        $nextTehkval = Tehkval::where('id',$athlete->tehkval->last()->id+1)->first();

        return $nextTehkval->title;
    }

    public function changeUserList($event, $users) {
        $users_limit = $event->users_limit;
        $main_list = DB::table('event_user')
            ->where('event_id', $event->id)
            ->where('list', Event::MAIN_LIST)
            ->count();
        $waiting_list = User::whereRelation('events', 'event_id', $event->id)->whereRelation('events', 'list', Event::WAITING_LIST)->count();

        if ($users_limit - $main_list <= 0) {
            return false;
        } else {
            $first_in_waiting = DB::table('event_user')
                ->where('event_id', $event->id)
                ->where('list', Event::WAITING_LIST)
                ->min('created_at');

            DB::table('event_user')
                ->where('event_id', $event->id)
                ->where('list', Event::WAITING_LIST)
                ->where('created_at', $first_in_waiting)
                ->update(['list' => Event::MAIN_LIST, 'created_at' => Carbon::now()]);
            return true;
        }

    }

    public function getCoachAthleteCount($event_id)
    {
        $event = Event::where('id', $event_id)->with('users')->first();
        $coachIds = [];
        foreach ($event->users as $user)
        {
            foreach ($user->athlete->coaches as $coach)
            {
                if ($coach->pivot->coach_type == Coach::REAL_COACH) {
                    $coachIds[] = $coach->id;
                }
            }

        }

        $coaches = [];
        $athletes = [];
        foreach (array_count_values($coachIds) as $key => $value) {
            $coach = Coach::with('user')->where('id', $key)->first();
            $coaches[] = $coach->user->secondname.' '.mb_substr($coach->user->firstname, 0, 1).'.'.mb_substr($coach->user->patronymic, 0, 1).'.';
            $athletes[] = $value;
        }

        return array_combine($coaches, $athletes);
    }
}

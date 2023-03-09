<?php


namespace App\BusinessProcess;


use App\Models\Athlete;
use App\Models\Coach;
use App\Models\Event;
use App\Models\Parented;
use App\Models\Tehkval;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GetEventUsers
{
    public function getUsers (int $id)
    {
        $coach = Coach::where('user_id', $id)->first();
        $parented = Parented::where('user_id', $id)->first();

        if ($coach) {
            $coach_athletes = DB::table('athlete_coach')
                ->where('coach_type', Coach::REAL_COACH)
                ->where('coach_id', $coach->id)->get();

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

    public function changeUserList($event, $users) {
        $users_limit = $event->users_limit;
        $main_list = User::whereRelation('events', 'list', Event::MAIN_LIST)->count();
        $waiting_list = User::whereRelation('events', 'list', Event::WAITING_LIST)->count();

        if ($users_limit - $main_list <= 0) {
            return false;
        }
        $first_in_waiting = DB::table('event_user')
            ->where('list', Event::WAITING_LIST)
            ->min('created_at');

        DB::table('event_user')
            ->where('list', Event::WAITING_LIST)
            ->where('created_at', $first_in_waiting)
            ->update(['list'=>Event::MAIN_LIST, 'created_at' => Carbon::now()]);
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

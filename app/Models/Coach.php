<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Coach extends Model
{
    use HasFactory;

    public const FIRST_COACH = 1;
    public const SECOND_COACH = 2;
    public const THIRD_COACH = 3;
    public const REAL_COACH = 4;

    public const TYPE = [
        self::FIRST_COACH,
        self::SECOND_COACH,
        self::THIRD_COACH,
        self::REAL_COACH
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->with('organizations');
    }

    public function athletes()
    {
        return $this->belongsToMany(Athlete::class, 'athlete_coach')->with('user')->withPivot('coach_type');
    }

    public static function getId()
    {
        $coach = Coach::where('user_id', auth()->user()->id)->with('user')->first();

        return $coach->id;
    }

    public static function getCoachId()
    {
        $coach = Coach::where('user_id', auth()->user()->id)->with('user')->first();

        if ($coach) {
            return $coach->id;
        }
    }

    public function getAthletes($coach_id, $userFilter, $athleteFilter)
    {
        return Athlete::with('user', 'birthcertificate', 'passport', 'studyplace', 'tehkval')
            ->whereHas('user', function (Builder $query) use ($userFilter) {
                $query->filter($userFilter);
            })
            ->whereHas('coaches', function (Builder $query) use ($coach_id) {
                $query->where('coach_id', '=', $coach_id)
                    ->where('coach_type', '=', Coach::REAL_COACH);
            })
            ->filter($athleteFilter)
            ->orderBy(function ($query) {
                $query->select('secondname')->from('users')->whereColumn('users.id', 'athletes.user_id');
            }, 'asc')
            ->paginate(10);
    }


    public function getCountAthletes($coach_id, $athleteFilter)
    {
        return Athlete::whereRelation('coaches', 'coach_id', $coach_id)->filter($athleteFilter)->count();
    }

    public function getAllCoaches()
    {
        return Coach::get();
        //TODO: изменить запрос всех тренеров из организации с сортировкой по фио
    }
}

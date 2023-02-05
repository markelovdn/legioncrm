<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Coach extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class)->with('organizations');
    }

    public function athletes()
    {
        return $this->belongsToMany(Athlete::class, 'athlete_coach')->with('user')->withPivot('coach_type');
    }

    public static function getId() {
        $coach = Coach::where('user_id', auth()->user()->id)->with('user')->first();

        return $coach->id;
    }

    public static function getCoachId() {
        $coach = Coach::where('user_id', auth()->user()->id)->with('user')->first();

        if ($coach) {
            return $coach->id;
        }

    }

    public function getAthletes($coach_id, $search_field)
    {
        return Athlete::whereHas('user', function (Builder $query) use ($search_field) {
            $query->where('secondname', 'like', '%'.$search_field.'%');
            })->with('user', 'birthcertificate', 'passport', 'studyplace')
            ->whereRelation('coaches', 'coach_id', $coach_id)
            ->get();
    }


}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coach extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function athletes()
    {
        return $this->belongsToMany(Athlete::class)->with('user')->withPivot('coach_type');
    }

    public static function getId() {
        $coach = Coach::where('user_id', auth()->user()->id)->with('user')->first();

        return $coach->id;
    }

    public static function getCoachId() {
        $coach = Coach::where('user_id', auth()->user()->id)->with('user')->first();

        return $coach->id;
    }


}

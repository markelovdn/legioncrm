<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class Attestation extends Model
{
    use HasFactory;

    public const APPROVE = 1;
    public const NOTAPPROVE = 2;

    public function organization()
    {
        return $this->hasOne(Organization::class);
    }

    public function athletes()
    {
        return $this->belongsToMany(Athlete::class);
    }

    public function hasAthlete ($attestation_id, $athlete_id)
    {
        $attestation_athletes = DB::table('athlete_attestation')->where('attestation_id', $attestation_id)->get();

        foreach ($attestation_athletes as $attestation_athlete) {
            if ($attestation_athlete->athlete_id == $athlete_id)
            {
                return true;
            }

        }

        return false;
    }

}

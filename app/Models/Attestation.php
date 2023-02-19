<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Attestation extends Model
{
    use HasFactory;

    public const APPROVE = 1;
    public const NOTAPPROVE = 2;
    public const STATUS_OPEN = 1;
    public const STATUS_CLOSE = 2;
    public const ACTIVE = 1;
    public const ARCHIVE = 2;

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

    public static function getOwner($attestation_id)
    {
        if (!Auth::user()){
            return false;
        }

        $chair_man = User::hasRole(Role::ROLE_ORGANIZATION_CHAIRMAN, \auth()->user()->getAuthIdentifier());
        $admin_org = User::hasRole(Role::ROLE_ORGANIZATION_ADMIN, \auth()->user()->getAuthIdentifier());

        if(!$chair_man and !$admin_org) {
            return false;
        }

        $orgs = User::getUserOrganizations(\auth()->user()->id);

        $orgs_id = [];
        foreach ($orgs as $org) {
            $orgs_id[] = $org->id;
        }

        $attestation = DB::table('attestations')
            ->where('id', $attestation_id)
            ->whereIn('organization_id', $orgs_id)->first();

        if ($attestation) {
            return true;
        }
        return false;
    }

    public function athletesCount(int $attestation_id) :int
    {
        if (!$attestation_id) {
            session()->flash('error', 'Не удается найти аттестацию');
        }
        return count(DB::table('athlete_attestation')->where('attestation_id', $attestation_id)->get());
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Organization extends Model
{
    use HasFactory;

    public function athletes()
    {
        return $this->belongsToMany(Athlete::class)->withPivot('coach_type');
    }

    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function workplaces()
    {
        return $this->hasMany(WorkPlace::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->with('athlete');
    }

    public static function getChairman()
    {
        $user = User::with('organizations')->where('id', auth()->user()->id)->whereRelation('role', 'code', Role::ROLE_ORGANIZATION_CHAIRMAN)->first();

        $org_count = $user->organizations->count();

        if ($org_count >= 1) {
            return $user;
        } return false;
    }

    public function getOrganizationId() :int
    {
        $id = auth()->user()->id;

        $oranization_id = DB::table('organization_user')->where('user_id', $id)->first();
        return $oranization_id->organization_id;
    }

    public function getAthletes()
    {
        $organization = Organization::with('users')->where('id', Organization::getOrganizationId())->first();

        $organization_athletes = [];
        foreach ($organization->users as $athlete) {
            if ($athlete->athlete != null) {
                $organization_athletes[] = $athlete->athlete;
            }
        }
        return $organization_athletes;
    }
}

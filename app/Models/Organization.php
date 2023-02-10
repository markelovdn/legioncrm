<?php

namespace App\Models;

use App\Filters\UserFilter;
use Illuminate\Database\Eloquent\Builder;
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

    public function getAthletes($organization_id, $userFilter, $athleteFilter)
    {
        return Athlete::whereHas('user', function (Builder $query) use ($userFilter) {
            $query->filter($userFilter);
        })->whereHas('user', function (Builder $query) use ($organization_id) {
            $query->whereRelation('organizations', 'organization_id', $organization_id);
        })->filter($athleteFilter)->with('user', 'birthcertificate', 'passport', 'studyplace')->paginate(10);

        //TODO: сделать сортировку по фамилии
    }

    public function getCountAthletes($organization_id, $athleteFilter)
    {
        return Athlete::whereHas('user', function (Builder $query) use ($organization_id) {
            $query->whereRelation('organizations', 'organization_id', $organization_id);
        })->filter($athleteFilter)->count();
    }
}

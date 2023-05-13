<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Competition extends Model
{
    use HasFactory;

    public const REGISTRATION_OPEN = 1;
    public const REGISTRATION_CLOSE = 2;

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function status()
    {
        return $this->belongsTo(CompetitionsRanksTitle::class);
    }

    public function agecategories()
    {
        return $this->belongsToMany(AgeCategory::class,
            'competition_agecategory',
            'competition_id',
            'agecategory_id');
    }

    public function tehkvalsgroups()
    {
        return $this->hasMany(TehkvalGroup::class);
    }

    public function organizations()
    {
        return $this->belongsToMany(Organization::class,
            'competition_organization',
            'competition_id',
            'organization_id');
    }

    public function competitors()
    {
        return $this->belongsToMany(Competitor::class);
    }

    public static function getOwner($competition_id)
    {
        if (!Auth::user()){
            return false;
        }

        $chair_man = User::hasRole(Role::ROLE_ORGANIZATION_CHAIRMAN, \auth()->user()->getAuthIdentifier());
        $admin_org = User::hasRole(Role::ROLE_ORGANIZATION_ADMIN, \auth()->user()->getAuthIdentifier());

        if(!$chair_man and !$admin_org) {
            return false;
        }

        $orgs = Auth::user()->getUserOrganizations(\auth()->user()->id);

        $orgs_id = [];
        foreach ($orgs as $org) {
            $orgs_id[] = $org->id;
        }

        $competition = DB::table('competition_organization')
            ->where('competition_id', $competition_id)
            ->whereIn('organization_id', $orgs_id)->get();

        if ($competition->count() >= 1) {
            return true;
        }
        return false;
    }

    public function competitorsCount(int $competition_id) :int
    {
        if (!$competition_id) {
            session()->flash('error', 'Нет соревнований с данным id');
        }
        return count(DB::table('competition_competitor')->where('competition_id', $competition_id)->get());
    }

    public function competitorsCountAgecategory(int $competition_id, int $agecategory_id) :int
    {
        if (!$competition_id) {
            session()->flash('error', 'Нет соревнований с данным id');
        }

        $competition = Competition::where('id', $competition_id)->first();

        return count($competition->competitors()->where('agecategory_id', $agecategory_id)->get());

    }

    public function competitorsCountWeightcategory(int $competition_id, int $weightcategory_id) :int
    {
        if (!$competition_id) {
            session()->flash('error', 'Нет соревнований с данным id');
        }

        $competition = Competition::where('id', $competition_id)->first();

        return count($competition->competitors()
            ->where('weightcategory_id', $weightcategory_id)
            ->get());
    }

    public function competitorsCountTehkvalgroup(int $competition_id, $weightcategory_id = null, int $tehkvalgroup_id) :int
    {
        if (!$competition_id) {
            session()->flash('error', 'Нет соревнований с данным id');
        }

        $competition = Competition::where('id', $competition_id)->first();

        return count($competition->competitors()
            ->where('weightcategory_id', $weightcategory_id)
            ->where('tehkvalgroup_id', $tehkvalgroup_id)
            ->get());
    }

//    public function competitorsCountCoach(int $competition_id, int $coach_id) :int
//    {
//        if (!$competition_id) {
//            session()->flash('error', 'Нет соревнований с данным id');
//        }
//
//        $competition = Competition::where('id', $competition_id)->first();
//
//        return count($competition->competitors()
//            ->with('coaches')
//            ->where('weightcategory_id', $weightcategory_id)
//            ->get());
//    }

}

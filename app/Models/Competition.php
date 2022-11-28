<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Competition extends Model
{
    use HasFactory;

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

        $chair_man = User::hasRole(Role::ROLE_ORGANIZATION_CHAIRMAN, \auth()->user()->id);
        $admin_org = User::hasRole(Role::ROLE_ORGANIZATION_ADMIN, \auth()->user()->id);

        if(!$chair_man and !$admin_org) {
            return false;
        }

        $orgs = User::getUserOrganizations(\auth()->user()->id);

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

}

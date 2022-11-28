<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

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

    public function getOwner()
    {

    }

}

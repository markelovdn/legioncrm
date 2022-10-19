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
        return $this->hasOne(Country::class);
    }

    public function district()
    {
        return $this->hasOne(District::class);
    }

    public function region()
    {
        return $this->hasOne(Region::class);
    }

    public function agecategories()
    {
        return $this->belongsToMany(AgeCategory::class,
            'competition_agecategory',
            'competition_id',
            'agecategory_id');
    }

    public function competition_agecategories(Request $request)
    {
        $competition = Competition::find($request->competition_id);

        $competition->agecategories()->detach();
        $competition->agecategories()->attach($request->agecategory);
    }

}

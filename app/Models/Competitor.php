<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\AgeCategory;
use App\Models\TehkvalGroup;
use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

class Competitor extends Model
{
    use HasFactory;

    protected $fillable = ['lot'];

    public function getAgeCategory(Request $request) {

        $competitor_date = Carbon::parse($request->date_of_birth)->year;
        $now = Carbon::now()->year;
        $competitor_age = $now - $competitor_date;
        $ageCategories = AgeCategory::all();
        $age_category = "";
        foreach ($ageCategories as $ageCategory) {
            if ($competitor_age >= $ageCategory->age_start and $competitor_age <= $ageCategory->age_finish){
                $age_category = $ageCategory->id;
            }
        }

        return $age_category;
    }

    public function getWeightCategory(Request $request)
    {

        $weightCategories = WeightCategory::all();

        $weight_category = "";
        foreach ($weightCategories as $weightCategory) {
            if ($request->weight >= $weightCategory->weight_start
                and $request->weight <= $weightCategory->weight_finish
                and $request->gender == $weightCategory->gender
                and $this->getAgeCategory($request) == $weightCategory->agecategory_id) {
                $weight_category = $weightCategory->id;
            }
        }

        return $weight_category;
    }

    public function getTehKvalGroup(Request $request) {

        $tehKvalGroups = TehkvalGroup::all();

        $tehkval_group = "";
        foreach ($tehKvalGroups as $tehKvalGroup) {
            if ($request->tehkval_id >= $tehKvalGroup->startgyp_id
                and $request->tehkval_id <= $tehKvalGroup->finishgyp_id
                and $this->getAgeCategory($request) == $tehKvalGroup->agecategory_id) {
                $tehkval_group = $tehKvalGroup->id;
            }
            else {
                $request->session()->flash('error', 'Нет подходящей группы');
            }

        }

        return $tehkval_group;

    }

    public function scopeFilter(Builder $builder, QueryFilter $filter){
        return $filter->apply($builder);
    }
    public function tehkval()
    {
        return $this->belongsTo(Tehkval::class);
    }

    public function sportkval()
    {
        return $this->belongsTo(Sportkval::class);
    }

    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    public function tehkvalgroup()
    {
        return $this->belongsTo(TehkvalGroup::class);
    }

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }

    public function agecategory()
    {
        return $this->belongsTo(AgeCategory::class);
    }

    public function weightcategory()
    {
        return $this->belongsTo(WeightCategory::class);
    }
}

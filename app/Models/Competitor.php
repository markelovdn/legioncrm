<?php

namespace App\Models;

use App\Models\AgeCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use App\Models\TehkvalGroup;
use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class Competitor extends Model
{
    use HasFactory;

    protected $fillable = ['lot'];

    public function getAgeCategory($date_of_birth) {

        $competitor_date = Carbon::parse($date_of_birth)->year;
        $now = Carbon::now()->year;
        $competitor_age = $now - $competitor_date;
        $competition_age_category = DB::table('competition_agecategory')->get('agecategory_id');

        $age_category = AgeCategory::
                whereRaw($competitor_age.' between `age_start` and `age_finish`')
                    ->first()->id;

        if ($competition_age_category->whereIn('agecategory_id', $age_category)->isNotEmpty()) {
            return $age_category;
        } else {
            session()->flash('error', 'Нет подходящего возраста для данных соревнований');
        }
    }

    public function getWeightCategory($weight, $gender, $date_of_birth)
    {
        $weightCategories = WeightCategory::
            whereRaw($weight. ' between `weight_start` and `weight_finish` and `gender` = '
                .$gender.' and `agecategory_id` = '
                .$this->getAgeCategory($date_of_birth))
                ->first();

        if ($weightCategories) {
            return $weightCategories->id;
        }
        else {
            session()->flash('error', 'Нет подходящей весовой категории на данных соревнований');
        }
    }

    public function getTehKvalGroup($tehkval_id, $date_of_birth) {

        $tehKvalGroups = TehkvalGroup::
               whereRaw('agecategory_id = '.$this->getAgeCategory($date_of_birth).' and finishgyp_id >= '.$tehkval_id)
                ->first();

            if ($tehKvalGroups) {
                return $tehKvalGroups->id;
            }
            else {
                return session()->flash('error', 'Нет подходящей группы на данных соревнованиях');
            }
        }

    public function scopeFilter(Builder $builder, QueryFilter $filter){
        return $filter->apply($builder);
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

    public function competitions()
    {
        return $this->belongsToMany(Competition::class);
    }

    public function athlete()
    {
        return $this->belongsTo(Athlete::class)->with('user')->with('coaches');
    }
}

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
                    ->first();

        if(empty($age_category)) {
            session()->flash('error_age', 'Спортсмен данного возраста пока не может принимать участи в соревнованиях по спаррингу');
            return false;
        } else {
            if ($competition_age_category->whereIn('agecategory_id', $age_category->id)->isNotEmpty()) {
                return $age_category->id;
            } else {
                session()->flash('error_age', 'Нет подходящего возраста для данных соревнований');
                return false;
            }
        }
    }

    public static function getWeightCategory($weight, $gender, $date_of_birth)
    {
        $weightCategories = WeightCategory::
            whereRaw($weight. ' between `weight_start` and `weight_finish` and `gender` = '
                .$gender.' and `agecategory_id` = '
                .Competitor::getAgeCategory($date_of_birth))
                ->first();

        if ($weightCategories) {
            return $weightCategories->id;
        }
        else {
            session()->flash('error_weight', 'Нет подходящей весовой категории для данных соревнований');
            return false;
        }
    }

    public function getTehKvalGroup($tehkval_id, $date_of_birth) {

        $tehKvalGroups = TehkvalGroup::
               whereRaw('agecategory_id = '.Competitor::getAgeCategory($date_of_birth).
            ' and finishgyp_id >= '.$tehkval_id)
                ->first();

            if ($tehKvalGroups) {
                return $tehKvalGroups->id;
            }
            else {
                session()->flash('error_tehkval', 'Нет подходящей группы по технической квалификации для данных соревнований');
                return false;
            }
        }

    public static function checkUniqueCompetitorWeightCategory(
        $athlete_id, $agecategory_id, $weightcategory_id, $tehkvalgroup_id, $competition_id) {

        $competitor = Competitor::where('athlete_id', $athlete_id)
                                ->where('agecategory_id', $agecategory_id)
                                ->where('weightcategory_id', $weightcategory_id)
                                ->where('tehkvalgroup_id', $tehkvalgroup_id)
                                ->first();

        if ($competitor) {
            $competition = DB::table('competition_competitor')
                ->where('competition_id', $competition_id)
                ->where('competitor_id', $competitor->id)
                ->first();
                if ($competition){
                    session()->flash('error_unique_competitor', 'Данный спорстмен уже заявлен в весовой категории');
                    return false;
                    }
        } else {
            return true;
        }
    }

    public static function isCoachAthlete($athlete_id) {

        $coach = Coach::where('user_id', \auth()->user()->id)->first();
        $athletes = DB::table('athlete_coach')->where('athlete_id', $athlete_id)->get();

        if($coach != null) {
            foreach ($athletes as $athlete) {
                if ($athlete->coach_id == $coach->id) {
                    return true;
                } else
                    return false;
            }
        } else
            return false;
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
        return $this->belongsTo(Athlete::class)
            ->with('user')
            ->with('coaches')
            ->with('tehkval')
            ->with('sportkval');
    }
}

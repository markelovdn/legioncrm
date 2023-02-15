<?php

namespace App\Models;

use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Athlete extends Model
{
    use HasFactory;

    public const GENDER_MALE = 1;
    public const GENDER_FEMALE = 2;
    public const ACTIVE = 1;
    public const INACTIVE = 2;

    protected $fillable = ['firstname', 'secondname', 'patronymic'];

    //beelongsTo
    public function birthcertificate()
    {
        return $this->belongsTo(BirthCertificate::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function medicalPolicy()
    {
        return $this->belongsTo(MedicalPolicy::class);
    }

    public function passport()
{
    return $this->belongsTo(Passport::class);
}

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function snils()
{
    return $this->belongsTo(Snils::class);
}

    public function studyplace()
    {
        return $this->belongsTo(StudyPlace::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->with('address');
    }

    //beelongsToMany
    public function groups()
    {
        return $this->belongsToMany(Group::class)->withPivot('created_at');;
    }

    public function coaches()
    {
        return $this->belongsToMany(Coach::class, 'athlete_coach')->with('user')->withPivot('coach_type');
    }

    public function tehkval()
    {
        return $this->belongsToMany(Tehkval::class, 'athlete_tehkval')->withPivot('created_at', 'sertificatenum', 'sertificate_link');
    }

    public function sportkval()
    {
        return $this->belongsToMany(Sportkval::class, 'athlete_sportkval');
    }

    public function organizations()
    {
        return $this->belongsToMany(Organization::class)->withPivot('org_type');
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class);
    }

    public function attestations()
    {
        return $this->belongsToMany(Attestation::class);
    }

    //hasOne
    public function insurance()
    {
    return $this->hasOne(Insurance::class);
    }

    //hasMany
    public function parenteds()
    {
        return $this->belongsToMany(Parented::class, 'athlete_parented', 'athlete_id', 'parented_id');
    }


    public function scopeFilter(Builder $builder, QueryFilter $filter){
        return $filter->apply($builder);
    }

    public function updateAthleteCoach ($athlete_id, $real_coach, $first_coach, $second_coach = null, $third_coach = null)
    {
        $athlete = Athlete::with(['coaches'])->find($athlete_id);
        if (empty($second_coach)) {
            $second_coach = $first_coach;
        }

        if (empty($third_coach)) {
            $third_coach = $first_coach;
        }

            $athlete->coaches()->sync([
                $second_coach => ['coach_type' => Coach::SECOND_COACH],
                $third_coach => ['coach_type' => Coach::THIRD_COACH],
                $first_coach => ['coach_type' => Coach::FIRST_COACH],
                $real_coach => ['coach_type' => Coach::REAL_COACH],
            ]);


    }

    public function getAddress($athlete_user_id)
    {
        return Address::with('country', 'region', 'district')
                        ->whereRelation('users', 'user_id', $athlete_user_id)
                        ->get();
    }

    public function getCoachesAthlete($athlete_id)
    {
        return Athlete::with('coaches')->find($athlete_id);
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


}

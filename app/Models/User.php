<?php

namespace App\Models;

use App\Filters\QueryFilter;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'secondname',
        'firstname',
        'patronymic',
        'email',
        'phone',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function athlete()
    {
        return $this->hasOne(Athlete::class)->with('user', 'birthcertificate', 'passport', 'studyplace', 'coaches', 'parenteds');
    }

    public function coach()
    {
        return $this->hasOne(Coach::class);
    }

    public function parented()
    {
        return $this->hasOne(Parented::class);
    }

    public function referee()
    {
        return $this->hasOne(Referee::class);
    }

    public function role()
    {
        return $this->belongsToMany(Role::class);
    }

    public function organizations()
    {
        return $this->belongsToMany(Organization::class);
    }

    public function address()
    {
        return $this->belongsToMany(Address::class)->with('country', 'district', 'region');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function events()
    {
        return $this->belongsToMany(Event::class);
    }

    public function getRole()
    {
        $user = User::with('role')->find(\auth()->user()->id);

        foreach ($user->role as $item) {
            return $item->name;
        }
    }

    public function getRoleCode(): string
    {
        $user = User::with('role')->find(auth()->user()->id);

        $roleCode = '';

        foreach ($user->role as $item) {
            $roleCode = $item->code;
        }

        return $roleCode;
    }


    public static function hasRole(string $role_code, int $user_id = null): bool
    {
        $role = Role::where('code', $role_code)->first();

        if (!$user_id) {
            return false;
        }

        $role_user = RoleUser::where('user_id', $user_id)->where('role_id', $role->id)->get();

        if ($role_user->count() < 1) {
            return false;
        }

        foreach ($role_user as $item) {
            if ($item->role_id == $role->id) {
                return true;
            } else
                return false;
        }
    }

    public static function hasOrganization($org_id, $user_id): bool
    {
        $organization = Organization::find($org_id);

        $org_user = DB::table('organization_user')
            ->where('organization_id', $organization->id)
            ->where('user_id', $user_id)->get();

        foreach ($org_user as $item) {
            if ($item->organization_id == $organization->id) {
                return true;
            } else
                return false;
        }
    }

    public function getUserOrganizations($user_id)
    {
        $org_user = DB::table('organization_user')
            ->where('user_id', $user_id)->get();
        $orgs = [];
        foreach ($org_user as $item) {
            $orgs[] = $item->organization_id;
        }

        $organizations = Organization::whereIn('id', $orgs)->get();

        if ($org_user) {
            return $organizations;
        } else
            return false;
    }

    public function checkUserUnique($firstname, $secondname, $patronymic, $dateOfBirth): bool
    {
        $user = User::where('firstname', $firstname)
            ->where('secondname', $secondname)
            ->where('patronymic', $patronymic)
            ->where('date_of_birth', $dateOfBirth)
            ->first();

        if ($user) {
            session()->flash('error_unique_user', 'Данные ФИО и дата рождения уже зарегистрированны в системе, войдите в личный кабинет и добавте спортсменов из личного кабинета, или свяжитесь с системным администратором');
            return false;
        }
        return true;
    }

    public function isSystemAdmin($user)
    {
        return Auth::user()->hasRole(\App\Models\Role::ROLE_SYSTEM_ADMIN, $user->id);
    }

    public function isOrganizationChairman(object $user): bool
    {
        if (!$user) {
            return false;
        }

        return Auth::user()->hasRole(\App\Models\Role::ROLE_ORGANIZATION_CHAIRMAN, $user->id);
    }

    public function isOrganizationAdmin(object $user): bool
    {
        if (!$user) {
            return false;
        }
        return Auth::user()->hasRole(\App\Models\Role::ROLE_ORGANIZATION_ADMIN, $user->id);
    }

    public function isCoach(object $user)
    {
        if (!$user) {
            return false;
        }

        return Auth::user()->hasRole(\App\Models\Role::ROLE_COACH, $user->id);
    }

    public function isParented(object $user)
    {
        if (!$user) {
            return false;
        }

        return Auth::user()->hasRole(\App\Models\Role::ROLE_PARENTED, $user->id);
    }

    public function isAthlete(object $user)
    {
        if (!$user) {
            return false;
        }

        return Auth::user()->hasRole(\App\Models\Role::ROLE_ATHLETE, $user->id);
    }

    public function isReferee(object $user)
    {
        if (!$user) {
            return false;
        }

        return Auth::user()->hasRole(\App\Models\Role::ROLE_REFEREE, $user->id);
    }

    public function scopeFilter(Builder $builder, QueryFilter $filter)
    {
        return $filter->apply($builder);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}

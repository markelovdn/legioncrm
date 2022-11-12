<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

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
        'role_id'
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
        return $this->hasOne(Athlete::class);
    }

    public function coach()
    {
        return $this->hasOne(Coach::class);
    }

    public function parented()
    {
        return $this->hasOne(Parented::class);
    }

    public function role()
    {
        return $this->belongsToMany(Role::class);
    }

    public function address()
    {
        return $this->belongsToMany(Address::class)->with('country', 'district', 'region');
    }

    public static function getRole()
    {
        $user = User::with('role')->find(auth()->user()->id);

        foreach ($user->role as $item) {
            return $item->code;
        }
    }

    public static function hasRole($role_id, $user_id)
    {
        $role_user = RoleUser::where('user_id', $user_id)->where('role_id', $role_id)->get();

        foreach ($role_user as $item) {
            if ($item->role_id == $role_id) {
                return true;
            } else
                return false;
        }
    }

    public static function checkUserUnique($firstname, $secondname, $patronymic, $dateOfBirth)
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




}

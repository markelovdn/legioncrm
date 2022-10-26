<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Role extends Model
{
    use HasFactory;

    public const ROLE_SYSTEM_ADMIN = 'system_admin';
    public const ROLE_ORGANIZATION_ADMIN = 'organization_admin';
    public const ROLE_ORGANIZATION_CHAIRMAN = 'organization_chairman';
    public const ROLE_COACH = 'coach';
    public const ROLE_PARENTED = 'parented';
    public const ROLE_ATHLETE = 'athlete';
    public const ROLE_REFEREE = 'referee';

    protected $fillable = ['id', 'name'];

    public function user()
    {
        return $this->belongsToMany(User::class)->with('roles');
    }
}

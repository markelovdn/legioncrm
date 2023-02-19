<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Event extends Model
{
    use HasFactory;
    public const OPEN_REGISTRATION = 1;
    public const CLOSE_REGISTRATION = 2;
    public const APPROVE = 1;
    public const DECLINE = 2;

    public function users()
    {
        return $this->belongsToMany(User::class)->with('athlete');
    }

    public static function getOwner($event_id)
    {
        if (!Auth::user()){
            return false;
        }

        $chair_man = User::hasRole(Role::ROLE_ORGANIZATION_CHAIRMAN, \auth()->user()->getAuthIdentifier());
        $admin_org = User::hasRole(Role::ROLE_ORGANIZATION_ADMIN, \auth()->user()->getAuthIdentifier());

        if(!$chair_man and !$admin_org) {
            return false;
        }

        $orgs = User::getUserOrganizations(\auth()->user()->id);

        $orgs_id = [];
        foreach ($orgs as $org) {
            $orgs_id[] = $org->id;
        }

        $event = DB::table('events')
            ->where('id', $event_id)
            ->whereIn('organization_id', $orgs_id)->get();

        if ($event->count() >= 1) {
            return true;
        }
        return false;
    }

    public function hasUsers ($event_id, $user_id)
    {
        $event_users = DB::table('event_user')
            ->orWhere(function($query) use ($event_id, $user_id) {$query->where('event_id', $event_id)
            ->where('user_id', $user_id);})
            ->first();

            if ($event_users)
            {
                return true;
            }

        return false;
    }
}

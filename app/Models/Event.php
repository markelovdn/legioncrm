<?php

namespace App\Models;

use Carbon\Carbon;
use Doctrine\DBAL\Events;
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
    public const ACCESS_ALL = 1;
    public const ACCESS_ORGANIZATION_USER = 2;
    public const PAYMENT_CONTROL_ORGANIZATION = 1;
    public const PAYMENT_CONTROL_COACH = 2;
    public const MAIN_LIST = 1;
    public const WAITING_LIST = 2;

    public function users()
    {
        return $this->belongsToMany(User::class)->with('athlete')->withPivot('list', 'approve', 'payment_id')->withTimestamps();
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

    public function getEvents ()
    {
        $userOrganizationsId = User::with('organizations')->find(auth()->id())->organizations->pluck('id')->toArray();
        $events_organization = Event::with('users')
            ->whereIn('organization_id', $userOrganizationsId)->orderBy('date_start', 'ASC')->get();

        if ($events_organization->count() == 0) {
            return Event::where('access', Event::ACCESS_ALL)->get();
        }
            return $events_organization;
    }

    public function getCountMainList ($event_id) {
        return DB::table('event_user')->where('event_id', $event_id)
            ->where('list', Event::MAIN_LIST)->count();
    }

    public function getCountWaitingList ($event_id) {
        return DB::table('event_user')->where('event_id', $event_id)
            ->where('list', Event::WAITING_LIST)->count();
    }

    public function getCost(int $event_id) :int
    {
        $event = Event::where('id', $event_id)->first();

        if ($event->early_cost_before && $event->early_cost_before > Carbon::now()) {
            return $event->early_cost;
        }
        return $event->regular_cost;
    }

//    public function getMinCost(int $event_id) :int
//    {
//        $event = Event::where('id', $event_id)->first();
//        return Event::getFullCost($event_id) * ($event->minimum_prepayment_percent / 100);
////        $event = Event::where('id', $event_id)->first();
////
////        if ($event->early_cost_before && $event->early_cost_before < Carbon::now()) {
////            return $event->early_cost * ($event->minimum_prepayment_percent / 100);
////        }
////            return $event->regular_cost * ($event->minimum_prepayment_percent / 100);
//    }


    public function isBookingWithoutPay(int $event_id) : bool
    {
        $event = Event::where('id', $event_id)->first();

        if ($event->booking_without_payment_before && !$event->date_start < Carbon::now()->addRealDays($event->booking_without_payment_before)->toDateString()) {
            return true;
        }
        return false;
    }
}

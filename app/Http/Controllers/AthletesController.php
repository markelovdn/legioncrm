<?php

namespace App\Http\Controllers;

use App\BusinessProcess\UploadFile;
use App\DomainService\AttachOrganization;
use App\Filters\AthleteFilter;
use App\Filters\UserFilter;
use App\Http\Requests\StoreAthleteRequest;
use App\Http\Requests\UpdateAthleteCoachesRequest;
use App\Models\Athlete;
use App\Models\Coach;
use App\Models\Country;
use App\Models\District;
use App\Models\Organization;
use App\Models\Parented;
use App\Models\Region;
use App\Models\Role;
use App\Models\Sportkval;
use App\Models\Tehkval;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AthletesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Athlete[]|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function index(AthleteFilter $athleteFilter, UserFilter $userFilter, Request $request)
    {
        $organization = new Organization();
        $tehkvals = Tehkval::get();
        $countries = Country::get();
        $districts = District::get();
        $regions = Region::get();
        $user = auth()->user();
        $organization = Organization::with('users')->where('id', $organization->getOrganizationId())->first();
        $coaches = $organization->getCoaches($organization->id);

        if (Auth::user()->hasRole(Role::ROLE_PARENTED, $user->id)) {
            return redirect('/parented/'.$user->id);
        }

        if (Auth::user()->hasRole(Role::ROLE_COACH, $user->id)) {
            $coach = Coach::where('user_id', $user->id)->first();
            $coach_athletes = $coach->getAthletes($coach->id, $userFilter, $athleteFilter);
            $count_coach_athletes = $coach->getCountAthletes($coach->id, $athleteFilter);

            return view('coaches.athletes',
                ['count_coach_athletes' => $count_coach_athletes,
                 'user' => $user,
                    'coach' => $coach,
                    'athletes' => $coach_athletes,
                    'coach_athletes' => $coach_athletes,
                 'coaches' => $coaches,
                 'countries' => $countries, 'districts' => $districts, 'regions' => $regions, 'tehkvals' => $tehkvals]);
        }

        if (Auth::user()->hasRole(Role::ROLE_ORGANIZATION_ADMIN, $user->id) ||
            Auth::user()->hasRole(Role::ROLE_ORGANIZATION_CHAIRMAN, $user->id)) {

            $organization_athlete = $organization->getAthletes($organization->id, $userFilter, $athleteFilter);
            $count_athletes = $organization->getCountAthletes($organization->id, $athleteFilter);

            return view('organization.athletes',
                ['organization' => $organization,
                    'organization_athlete' => $organization_athlete,
                    'count_athletes' => $count_athletes,
                    'user' => $user,
                    'coaches' => $coaches,
                    'countries' => $countries,
                        'districts' => $districts,
                        'regions' => $regions,
                        'tehkvals' => $tehkvals]);
        }

        return back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreAthleteRequest $request)
    {
        $request->validated();

        $coaches = Coach::find($request->coach_id);
        $tehKval = Tehkval::find(1);
        $sportKval = Sportkval::find(1);

        if (!Auth::user()->checkUserUnique($request->firstname, $request->secondname, $request->patronymic, $request->date_of_birth)) {
            return back()->withInput();
        }

        if($coaches->code == $request->reg_code) {

        $user = new User();
        $user->secondname = $request->secondname;
        $user->firstname = $request->firstname;
        $user->patronymic = $request->patronymic;
        $user->date_of_birth = $request->date_of_birth;
        $user->save();

        $role = Role::where('code', Role::ROLE_ATHLETE)->get();
        $user->role()->attach($role);

            if ($request->hasFile('photo')) {
                $path_scanlink = UploadFile::uploadFile($user->id, $user->secondname,$user->firstname, 'photo', $request->file('photo'));
            }

            $athlete = new Athlete();
            $athlete->user_id = $user->id;
            $athlete->gender = $request->gender;
            $athlete->photo =  $path_scanlink;
            $athlete->status = Athlete::ACTIVE;
            $athlete->save();

            $athlete->coaches()->attach($coaches, ['coach_type' => Coach::FIRST_COACH]);
            $athlete->coaches()->attach($coaches, ['coach_type' => Coach::REAL_COACH]);
            $athlete->tehkval()->attach($tehKval->id, ['organization_id'=>$coaches->user->organizations->first()->id]);
            $athlete->sportkval()->attach($sportKval->id);

            AttachOrganization::attachOrganization(Role::ROLE_ATHLETE,  $user->id, $request->reg_code);
        }
        else{
            $request->session()->flash('error_coach_code', 'Не верный код тренера');
            return back()->withInput();
        }

        $parented = Parented::where('user_id', Auth::user()->id)->first();
        $athlete->parenteds()->attach($parented, ['parented_type' => 1]);

        return back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreAthleteRequest $request, $id)
    {
        $user = User::where('id', $request->input('user_id'))->first();
        $athlete = Athlete::where('id', $id)->first();

        if ($request->hasFile('photo')) {
            $path_scanlink = UploadFile::uploadFile($user->id, $user->secondname,$user->firstname, 'photo', $request->file('photo'));
            $athlete->photo =  $path_scanlink;
        }

        if ($request->has('gender')) {
            $athlete->gender = $request->gender;
        }

        if ($request->has('status')) {
            $athlete->status = $request->input('status');
        }

        if ($request->has('real_coach')) {
            Athlete::updateAthleteCoach($athlete->id,
                $request->input('real_coach'),
                $request->input('first_coach'),
                $request->input('second_coach'),
                $request->input('third_coach'));
        }

        $athlete->save();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|numeric',
            'user_id' => 'required|numeric'
        ]);

        $user = User::where('id', $request->input('user_id'))->first();
        $athlete = Athlete::where('id', $id)->first();
        $system_code = DB::table('system_codes')->where('code', $request->input('code'))->first();

                if ($system_code && Auth::user()->getRoleCode() == Role::ROLE_SYSTEM_ADMIN) {
                    DB::table('athlete_coach')->where('athlete_id', $id)->delete();
                    DB::table('athlete_parented')->where('athlete_id', $id)->delete();
                    DB::table('organization_user')->where('user_id', $user->id)->delete();
                    DB::table('role_user')->where('user_id', $user->id)->delete();
                    DB::table('address_user')->where('user_id', $user->id)->delete();
                    Athlete::destroy($id);
                    User::destroy($user->id);

                    return back();
                }

                session()->flash('error', 'Неизвестная роль');
                return back();




    }
}

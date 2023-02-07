<?php

namespace App\Http\Controllers;

use App\BusinessProcess\uploadFile;
use App\DomainService\AttachOrganization;
use App\Filters\UserFilter;
use App\Http\Requests\StoreAthleteRequest;
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
    public function index(UserFilter $userFilter, Request $request)
    {
        $id = auth()->user()->id;
        $countries = Country::get();
        $districts = District::get();
        $regions = Region::get();

        if (\App\Models\User::hasRole(Role::ROLE_PARENTED, $id)) {
            return redirect('/parented/'.$id);
        }

        if (\App\Models\User::hasRole(Role::ROLE_COACH, $id)) {
            $coach = Coach::where('user_id', $id)->first();
            $coach_athletes = Coach::getAthletes($coach->id, $request->input('search_field'));

            return view('coaches.athletes',
                ['coach' => $coach, 'coach_athletes' => $coach_athletes],
                ['countries' => $countries, 'districts' => $districts, 'regions' => $regions,]);
        }

        if (\App\Models\User::hasRole(Role::ROLE_ORGANIZATION_ADMIN, $id) ||
            \App\Models\User::hasRole(Role::ROLE_ORGANIZATION_CHAIRMAN, $id)) {
            $organization = Organization::with('users')->where('id', Organization::getOrganizationId())->first();
            $organization_athlete = Organization::getAthletes($organization->id, $request->input('search_field'));

            return view('organization.athletes',
                compact(['organization', $organization, 'organization_athlete', $organization_athlete]),
                        ['countries' => $countries, 'districts' => $districts, 'regions' => $regions,]);
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


        if (!User::checkUserUnique($request->firstname, $request->secondname, $request->patronymic, $request->date_of_birth)) {
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
                $path_scanlink = uploadFile::uploadFile($user->id, $user->secondname,$user->firstname, 'photo', $request->file('photo'));
            }

            $athlete = new Athlete();
            $athlete->user_id = $user->id;
            $athlete->gender = $request->gender;
            $athlete->photo =  $path_scanlink;
            $athlete->status = Athlete::ACTIVE;
            $athlete->save();

            $athlete->coaches()->attach($coaches, ['coach_type' => 1]);
            $athlete->tehkval()->attach($tehKval->id);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
            $path_scanlink = uploadFile::uploadFile($user->id, $user->secondname,$user->firstname, 'photo', $request->file('photo'));
            $athlete->photo =  $path_scanlink;
        }

        if ($request->has('gender')) {
            $athlete->gender = $request->gender;
        }

        if ($request->has('status')) {
            $athlete->status = Athlete::INACTIVE;
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
    public function destroy($id)
    {
        //
    }
}

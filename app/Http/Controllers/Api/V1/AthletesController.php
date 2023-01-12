<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAthleteRequest;
use App\Models\Athlete;
use App\Models\BirthCertificate;
use App\Models\Coach;
use App\Models\Organization;
use App\Models\Parented;
use App\Models\Role;
use App\Models\Sportkval;
use App\Models\StudyPlace;
use App\Models\Tehkval;
use App\Models\User;
use http\Env\Url;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\isEmpty;

class AthletesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Athlete[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\Response
     */
    public function index()
    {
        $id = auth()->user()->id;

        if (\App\Models\User::hasRole(Role::ROLE_PARENTED, $id)) {
            return redirect('/parented/'.$id);
        }

        if (\App\Models\User::hasRole(Role::ROLE_COACH, $id)) {
            $coach = Coach::where('user_id', $id)->with('user', 'athletes')->first();
            return view('coaches.athletes', compact('coach', $coach));
        }

        if (\App\Models\User::hasRole(Role::ROLE_ORGANIZATION_ADMIN, $id) ||
            \App\Models\User::hasRole(Role::ROLE_ORGANIZATION_CHAIRMAN, $id)) {
            $organization = Organization::with('users')->where('id', Organization::getOrganizationId())->first();
            $organization_athlete = Organization::getAthletes();

            return view('organization.athletes', compact(['organization', $organization, 'organization_athlete', $organization_athlete]));
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

        $path_photo = 'athlete/'.$user->id.'_'.$user->secondname.'_'.$user->firstname.'/'.'photo_'.$user->secondname.'_'.$user->firstname.'_'.$user->patronymic.'.jpg';
        if ($request->hasFile('photo')) {
            $request->file('photo')
                ->storeAs('athlete/'.$user->id.'_'.$user->secondname.'_'.$user->firstname, 'photo_'.$user->secondname.'_'.$user->firstname.'_'.$user->patronymic.'.jpg');
        }

            $athlete = new Athlete();
            $athlete->user_id = $user->id;
            $athlete->gender = $request->gender;
            $athlete->photo =  $path_photo;
            $athlete->status = 1;
            $athlete->save();

            $athlete->coaches()->attach($coaches, ['coach_type' => 1]);
            $athlete->tehkval()->attach($tehKval->id);
            $athlete->sportkval()->attach($sportKval->id);
        }
        else{
            $request->session()->flash('status', 'Не верный код тренера');
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
    public function update(Request $request, $id)
    {
        //
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

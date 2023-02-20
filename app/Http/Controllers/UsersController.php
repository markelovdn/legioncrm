<?php

namespace App\Http\Controllers;

use App\BusinessProcess\GetRegistrationCode;
use App\DomainService\AttachOrganization;
use App\DomainService\RegistrationUserAs;
use App\Http\Requests\StoreUserRequest;
use App\Models\Coach;
use App\Models\Organization;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect('/');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function create(Request $request)
    {
        if($request->has('parent')) {
            $coaches = Coach::with('user')->get();
            return view('auth.parent-register', ['coaches'=>$coaches]);
        } elseif($request->has('referee')) {
            $orgs = Organization::all();
            return view('auth.referee-register', ['orgs'=>$orgs]);
        } elseif($request->has('coach')) {
            $orgs = Organization::all();
            return view('auth.coach-register', ['orgs'=>$orgs]);
        } elseif($request->has('organization_chairman')) {
            return view('auth.org-register');
        } else
            return redirect('/');


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request, GetRegistrationCode $reg_code, RegistrationUserAs $userAs)
    {
        $request->validated();

        if ($request->role_code == Role::ROLE_PARENTED && Carbon::parse($request->date_of_birth)->diffInYears() < 18) {
            $request->session()->flash('error', 'Возраст родителя не должен быть младше 18 лет');
            return back()->withInput();
        }

        if (!$reg_code->getCode($request->reg_code, $request->role_code)) {
            $request->session()->flash('status', 'Не верный код');
            return back()->withInput();
        }

        if (!User::checkUserUnique($request->firstname, $request->secondname, $request->patronymic, $request->date_of_birth)) {
            return back()->withInput();
        }

        $user = new User();

        $user->firstname = $request->firstname;
        $user->secondname = $request->secondname;
        $user->patronymic = $request->patronymic;
        $user->date_of_birth = $request->date_of_birth;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);

        $user->save();

        $role = Role::where('code', $request->role_code)->get();

        $user->role()->attach($role);

        AttachOrganization::attachOrganization($request->role_code,  $user->id, $request->reg_code);

        Auth::login($user);

        return redirect($userAs->registrationUserAs($request->role_code, $user->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect('/');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return redirect('/');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUserRequest $request, $id)
    {
        $user = User::find($id);

        if (Auth::user()->id != $id && $request->role_code != Role::ROLE_ATHLETE){
            return redirect('/');
        }

        $request->validated();

        if ($request->role_code == Role::ROLE_PARENTED && Carbon::parse($request->date_of_birth)->diffInYears() < 18) {
            $request->session()->flash('error', 'Возраст родителя не должен быть младше 18 лет');
            return back()->withInput();
        }

        if (!User::checkUserUnique($request->firstname, $request->secondname, $request->patronymic, $request->date_of_birth)) {
            return back()->withInput();
        }

        $user->firstname = $request->firstname;
        $user->secondname = $request->secondname;
        $user->patronymic = $request->patronymic;
        $user->date_of_birth = $request->date_of_birth;

        $user->save();

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

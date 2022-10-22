<?php

namespace App\Http\Controllers\Api\V1;

use App\BusinessProcess\GetRegistrationCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\DomainService\RegistrationUserAs;
use App\Models\Coach;
use App\Models\Organization;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
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
        //
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
        } elseif($request->has('coach')) {
            $orgs = Organization::all();
            return view('auth.coach-register', ['orgs'=>$orgs]);
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

        if (!$reg_code->getCode($request->reg_code, $request->role_code)) {
            $request->session()->flash('status', 'Не верный код');
            return back()->withInput();
        }

        $user = new User();

        $user->firstname = $request->firstname;
        $user->secondname = $request->secondname;
        $user->patronymic = $request->patronymic;
        $user->date_of_birth = $request->date_of_birth;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->role_id = $request->role_id;
        $user->password = Hash::make($request->password);

        $user->save();

        $role = Role::where('code', $request->role_code)->get();

        $user->role()->attach($role);

        Auth::login($user);

        return redirect($userAs->registrationUserAs($request->role_code));
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

<?php

namespace App\Http\Controllers\Api\V1;

use App\DomainService\RegistrationUserAs;
use App\Http\Controllers\Controller;
use App\Models\Athlete;
use App\Models\Coach;
use App\Models\Parented;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleUserController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::get();
        $roles = Role::get();

        return view('system.role-user', ['users'=>$users, 'roles'=>$roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, RegistrationUserAs $registrationUserAs)
    {
        $request->validate([
            'role_id' => ['required'],
        ]);

        $roles = Role::whereIn('id', $request->role_id)->get();

        $user = User::find($request->user_id);

        $user->role()->detach();

        $user->role()->attach($request->role_id);

        $coach = Coach::where('user_id', $user->id)->first();
        $parent = Parented::where('user_id', $user->id)->first();
        $athlete = Athlete::where('user_id', $user->id)->first();

        foreach ($roles as $role){
            if (!$coach && $role->code == Role::ROLE_COACH) {
                $registrationUserAs->registrationUserAs(Role::ROLE_COACH, $user->id);
            }

            if (!$parent && $role->code == Role::ROLE_PARENTED) {
                $registrationUserAs->registrationUserAs(Role::ROLE_PARENTED, $user->id);
            }

            if (!$athlete && $role->code == Role::ROLE_ATHLETE) {
                $registrationUserAs->registrationUserAs(Role::ROLE_ATHLETE, $user->id);
            }
        }

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

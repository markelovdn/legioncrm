<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Athlete;
use App\Models\Coach;
use App\Models\Organization;
use App\Models\Parented;
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
        $validate = $request->validate([
            'secondname' => ['required', 'string', 'max:255'],
            'firstname' => ['required', 'string', 'max:255'],
            'patronymic' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['required', 'date'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'unique:users'],
            'role_id' => ['required', 'integer'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $reg_code = "";
        switch ($request->role_id) {
            case ("5"): $reg_code = Coach::find($request->input('coach_id'));
                break;
            case ("4"): $reg_code = Organization::find($request->input('org_id'));
                break;
        };

            if($reg_code->code == $request->reg_code) {
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
                Auth::login($user);
                switch ($request->role_id) {
                    case ("5"):  $parented = new Parented();
                        $parented->user_id = auth()->user()->id;
                        $parented->save();
                        return redirect('/parented/'.$parented->id);
                    case ("4"):
                        $coach = new Coach();
                        $coach->user_id = auth()->user()->id;
                        $coach->code = rand(1000, 9999);
                        $coach->save();
                        return redirect('/coach/'.$coach->id);
                }
            }
            else{
                $request->session()->flash('status', 'Неверный код');
                return back()->withInput();
            }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

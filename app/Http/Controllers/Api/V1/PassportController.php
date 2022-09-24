<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Athlete;
use App\Models\Coach;
use App\Models\Parented;
use App\Models\Passport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PassportController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
//        $validate = $request->validate([
//            'secondname' => ['required', 'string', 'max:255'],
//            'firstname' => ['required', 'string', 'max:255'],
//            'patronymic' => ['required', 'string', 'max:255'],
//            'date_of_birth' => ['required', 'date'],
//            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
//            'phone' => ['required', 'unique:users'],
//            'role_id' => ['required', 'integer'],
//            'password' => ['required', 'string', 'min:6', 'confirmed'],
//        ]);

        if ($request->user_id) {
        $user = User::where('id', $request->user_id)->first();
        $path_scanlink = 'athlete/'.$user->id.'_'.$user->secondname.'_'.$user->firstname.'/'.'passport_'.$user->secondname.'_'.$user->firstname.'_'.$user->patronymic.'.jpg';

            $passport = Passport::updateOrCreate(
                ['series' => $request->passport_series, 'number' => $request->passport_number],
                [
                    'dateissue' => $request->passport_date_issue,
                    'issuedby' => $request->passport_issued_by,
                    'code' => $request->passport_subcode,
                    'scanlink' => $path_scanlink
                ]
            );
        }

        if ($request->hasFile('passport_scan')) {
            $request->file('passport_scan')
                ->storeAs('athlete/'.$user->id.'_'.$user->secondname.'_'.$user->firstname, 'passport_'.$user->secondname.'_'.$user->firstname.'_'.$user->patronymic.'.jpg');

        }

        $passport = Passport::updateOrCreate(
            ['series' => $request->passport_series, 'number' => $request->passport_number],
            [
                'dateissue' => $request->passport_date_issue,
                'issuedby' => $request->passport_issued_by,
                'code' => $request->passport_subcode,
            ]
        );

        if (isset($request->role_id)) {
            $athlete = Athlete::find($request->athlete_id);
            $athlete->passport_id = $passport->id;
            $athlete->save();
            return redirect('/parented/'.Parented::getParentedId());
        } else {

            switch (Auth::user()->role_id) {
                case ("5"):
                    $parented = Parented::find(Parented::getParentedId());
                    $parented->passport_id = $passport->id;
                    $parented->save();
                    return redirect('/parented/' . Parented::getParentedId());
                case ("4"):
                    $coach = Coach::find(Coach::getCoachId());
                    $coach->passport_id = $passport->id;
                    $coach->save();
                    return redirect('/coach/' . Coach::getCoachId());

            }
        }

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

<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Athlete;
use App\Models\BirthCertificate;
use App\Models\Coach;
use App\Models\Parented;
use App\Models\StudyPlace;
use App\Models\User;
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
        return Athlete::all();
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
    public function store(Request $request)
    {
        $validate = $request->validate([
            'photo' => ['required', 'image:jpg,jpeg,png,bmp'],
            'gender' => ['required', 'string', 'max:7'],
            'secondname' => ['required', 'string', 'max:255'],
            'firstname' => ['required', 'string', 'max:255'],
            'patronymic' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['required', 'date'],
        ]);

        $user = new User();
        $user->secondname = $request->secondname;
        $user->firstname = $request->firstname;
        $user->patronymic = $request->patronymic;
        $user->date_of_birth = $request->date_of_birth;
        $user->role_id = 6;
        $user->save();

        $path_photo = 'athlete/'.$user->id.'_'.$user->secondname.'_'.$user->firstname.'/'.'photo_'.$user->secondname.'_'.$user->firstname.'_'.$user->patronymic.'.jpg';
        if ($request->hasFile('photo')) {
            $request->file('photo')
                ->storeAs('athlete/'.$user->id.'_'.$user->secondname.'_'.$user->firstname, 'photo_'.$user->secondname.'_'.$user->firstname.'_'.$user->patronymic.'.jpg');
        }

        $coaches = Coach::find($request->coach_id);

        if($coaches->code == $request->reg_code) {
            $athlete = new Athlete();
            $athlete->user_id = $user->id;
            $athlete->gender = $request->gender;
            $athlete->photo =  $path_photo;
            $athlete->status = 1;
            $athlete->save();

            $athlete->coaches()->attach($coaches, ['coach_type' => 1]);
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

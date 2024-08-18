<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudyPlaceRequest;
use App\Models\Athlete;
use App\Models\BirthCertificate;
use App\Models\Organization;
use App\Models\StudyPlace;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudyPlaceController extends Controller
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreStudyPlaceRequest $request)
    {
        $request->validated();

        $user = User::where('id', $request->user_id)->first();

        $studyplace = new StudyPlace();
        $studyplace->org_title = $request->org_title;
        $studyplace->classnum = $request->classnum;
        $studyplace->letter = $request->letter;
        $studyplace->save();

        Athlete::where('user_id', $user->id)->update(['studyplace_id' => $studyplace->id]);
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
    public function update(StoreStudyPlaceRequest $request, $id)
    {
        $request->validated();

        $user = User::where('id', $request->user_id)->first();

        $studyplace = StudyPlace::where('id', $id)->first();
        $studyplace->org_title = $request->org_title;
        $studyplace->classnum = $request->classnum;
        $studyplace->letter = $request->letter;
        $studyplace->save();

        Athlete::where('user_id', $user->id)->update(['studyplace_id' => $studyplace->id]);
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
        $organization_id = Organization::getOrganizationId();
        $organization = Organization::where('id', $organization_id)->first();

        switch(Auth::user()->getRoleCode()) :
            case(\App\Models\Role::ROLE_SYSTEM_ADMIN) :
            case(\App\Models\Role::ROLE_ORGANIZATION_CHAIRMAN) :
            case(\App\Models\Role::ROLE_ORGANIZATION_ADMIN) :

                if ($organization->code == $request->input('code')) {
                    $athlete = Athlete::where('studyplace_id', $id)->first();
                    $athlete->studyplace_id = null;
                    $athlete->save();

                    StudyPlace::destroy($id);
                    return back();
                }
                break;
            default:
                session()->flash('error', 'Неизвестная роль');
                return back();

        endswitch;
    }
}

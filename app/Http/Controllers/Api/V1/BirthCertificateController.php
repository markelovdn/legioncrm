<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBirthCertificateRequest;
use App\Models\Athlete;
use App\Models\BirthCertificate;
use App\Models\StudyPlace;
use App\Models\User;
use Illuminate\Http\Request;

class BirthCertificateController extends Controller
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
    public function store(StoreBirthCertificateRequest $request)
    {
        $request->validated();

        $user = User::where('id', $request->user_id)->first();

        $path_scanlink = 'athlete/'.$user->id.'_'.$user->secondname.'_'.$user->firstname.'/'.'birthcertificate_'.$user->secondname.'_'.$user->firstname.'_'.$user->patronymic.'.jpg';
        if ($request->hasFile('birthcertificate_scan')) {
            $request->file('birthcertificate_scan')
                ->storeAs('athlete/'.$user->id.'_'.$user->secondname.'_'.$user->firstname, 'birthcertificate_'.$user->secondname.'_'.$user->firstname.'_'.$user->patronymic.'.jpg');

        }

        $birthcertificate = new BirthCertificate();
        $birthcertificate->series = $request->birthcertificate_series;
        $birthcertificate->number = $request->birthcertificate_number;
        $birthcertificate->dateissue = $request->birthcertificate_date_issue;
        $birthcertificate->issuedby = $request->birthcertificate_issued_by;
        $birthcertificate->scanlink = $path_scanlink;
        $birthcertificate->save();

        Athlete::where('user_id', $user->id)->update(['birthcertificate_id' => $birthcertificate->id]);
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

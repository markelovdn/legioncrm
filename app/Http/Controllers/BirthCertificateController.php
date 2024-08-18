<?php

namespace App\Http\Controllers;

use App\BusinessProcess\UploadFile;
use App\Http\Requests\StoreBirthCertificateRequest;
use App\Models\Athlete;
use App\Models\BirthCertificate;
use App\Models\Organization;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        if ($request->hasFile('birthcertificate_scan')) {
            $UploadFile = new UploadFile();
            $path_scanlink = $UploadFile->uploadFile($user->id, $user->secondname, $user->firstname, 'birthcertificate', $request->file('birthcertificate_scan'));
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
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreBirthCertificateRequest $request, int $id)
    {
        $request->validated();

        $user = User::where('id', $request->input('user_id'))->first();

        $birthcertificate = BirthCertificate::find($id);

        if ($request->hasFile('birthcertificate_scan')) {
            $UploadFile = new UploadFile();
            $path_scanlink = $UploadFile->uploadFile($user->id, $user->secondname, $user->firstname, 'birthcertificate', $request->file('birthcertificate_scan'));
            $birthcertificate->scanlink = $path_scanlink;
        }


        $birthcertificate->series = $request->birthcertificate_series;
        $birthcertificate->number = $request->birthcertificate_number;
        $birthcertificate->dateissue = $request->birthcertificate_date_issue;
        $birthcertificate->issuedby = $request->birthcertificate_issued_by;

        $birthcertificate->save();

        Athlete::where('user_id', $user->id)->update(['birthcertificate_id' => $birthcertificate->id]);
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
        $org = new Organization;
        $organization_id = $org->getOrganizationId();
        $organization = Organization::where('id', $organization_id)->first();

        switch (Auth::user()->getRoleCode()):
            case (\App\Models\Role::ROLE_SYSTEM_ADMIN):
            case (\App\Models\Role::ROLE_ORGANIZATION_CHAIRMAN):
            case (\App\Models\Role::ROLE_ORGANIZATION_ADMIN):

                if ($organization->code == $request->input('code')) {
                    $athlete = Athlete::where('birthcertificate_id', $id)->first();
                    $athlete->birthcertificate_id = null;
                    $athlete->save();

                    BirthCertificate::destroy($id);
                    return back();
                }
                break;
            default:
                session()->flash('error', 'Неизвестная роль');
                return back();

        endswitch;
    }
}

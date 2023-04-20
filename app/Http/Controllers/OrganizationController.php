<?php

namespace App\Http\Controllers;

use App\BusinessProcess\UploadFile;
use App\Http\Requests\StoreOrganizationRequest;
use App\Models\Organization;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('organization.about');
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
        $org = Organization::with('users')->find($id);
        $user = Organization::getChairman();

        if (!$user) {
            $user = Organization::getOrganizationAdmin();
        }

        $orgs_chairmans = User::with('organizations')->whereRelation('role', 'code', Role::ROLE_ORGANIZATION_CHAIRMAN)->get();

        foreach ($orgs_chairmans as $org_chairman) {
            foreach ($org_chairman->organizations as $organization)
            if ($organization->id == $id) {
                $chairman_name = $org_chairman->secondname.' '.$org_chairman->firstname.' '.$org_chairman->patronymic;
            }
        }

        if (!$org and !$user) {
            return redirect('/');
        }

        return view('organization.cabinet', ['org' => $org, 'user' => $user, 'chairman_name' => $chairman_name]);
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
    public function update(StoreOrganizationRequest $request, $id)
    {
        $request->validated();

        $user = User::where('id', auth()->user()->id)->first();

        if ($request->hasFile('logo')) {
            $path_scanlink = UploadFile::uploadFile($user->id, $user->secondname, $user->firstname, 'logo', $request->file('logo'));
        }

        $org = Organization::find($id);

        $org->fulltitle = $request->fulltitle;
        $org->shorttitle = $request->shorttitle;
        $org->address = $request->address;
        $org->email = $request->email;
        $org->phone = $request->phone;
        $org->inn = $request->inn;
        $org->ogrn = $request->ogrn;
        $org->primary_activity = $request->primary_activity;
        $org->logo = $path_scanlink ?? null;
        $org->code = $request->code;

        $org->save();

        session()->flash('status', 'Данные обновлены');

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

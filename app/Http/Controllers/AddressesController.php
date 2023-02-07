<?php

namespace App\Http\Controllers;

use App\BusinessProcess\uploadFile;
use App\Http\Requests\StoreAddressRequest;
use App\Models\Address;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AddressesController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAddressRequest $request)
    {
        $request->validated();

        $user = User::where('id', $request->user_id)->first();

        if ($request->hasFile('registration_scan')) {
            $path_scanlink = uploadFile::uploadFile($user->id, $user->secondname,$user->firstname, 'registration_scan', $request->file('registration_scan'));
        }

        $address = new Address();
        $address->country_id = $request->country_id;
        $address->district_id = $request->district_id;
        $address->region_id = $request->region_id;
        $address->address = $request->address;
        $address->scanlink =  $path_scanlink;
        $address->save();

        $user->address()->attach($address);

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
    public function update(StoreAddressRequest $request, $id)
    {
        $request->validated();

        $user = User::where('id', $request->user_id)->first();
        $address = Address::where('id', $id)->first();

        if ($request->hasFile('registration_scan')) {
            $path_scanlink = uploadFile::uploadFile($user->id, $user->secondname,$user->firstname, 'registration_scan', $request->file('registration_scan'));
            $address->scanlink =  $path_scanlink;
        }

        $address->country_id = $request->country_id;
        $address->district_id = $request->district_id;
        $address->region_id = $request->region_id;
        $address->address = $request->address;

        $address->save();

        $user->address()->detach($address);
        $user->address()->attach($address);

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
        $user = User::where('id', $request->user_id)->first();

        switch(\App\Models\User::getRoleCode()) :
            case(\App\Models\Role::ROLE_SYSTEM_ADMIN) :
            case(\App\Models\Role::ROLE_ORGANIZATION_CHAIRMAN) :
            case(\App\Models\Role::ROLE_ORGANIZATION_ADMIN) :

                if ($organization->code == $request->input('code')) {
                    $address = Address::where('id', $id)->first();
                    $user->address()->detach($address);

                    Address::destroy($id);

                    return back();
                }
                break;
            default:
                session()->flash('error', 'Неизвестная роль');
                return back();

        endswitch;
    }
}

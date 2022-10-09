<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAddressRequest;
use App\Models\Address;
use App\Models\User;
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

        $path_scanlink = 'athlete/'.$user->id.'_'.$user->secondname.'_'.$user->firstname.'/'.'registration_'.$user->secondname.'_'.$user->firstname.'_'.$user->patronymic.'.jpg';
        if ($request->hasFile('registration_scan')) {
            $request->file('registration_scan')
                ->storeAs('athlete/'.$user->id.'_'.$user->secondname.'_'.$user->firstname, 'registration_'.$user->secondname.'_'.$user->firstname.'_'.$user->patronymic.'.jpg');
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

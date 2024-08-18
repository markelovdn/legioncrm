<?php

namespace App\Http\Controllers;

use App\Models\Coach;
use App\Models\Country;
use App\Models\District;
use App\Models\Parented;
use App\Models\Region;
use Illuminate\Http\Request;

class ParentedsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Parented[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\Response
     */
    public function index()
    {
//        return Parented::all();
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

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $parented = Parented::where('user_id', auth()->user()->id)->with('user', 'passport', 'athletes')->find($id);

        if (!$parented) {
            return redirect('/');
        }

        $coaches = Coach::with('user')->get();
        $countries = Country::all();
        $districts = District::all();
        $regions = Region::all();

        return view('parented.cabinet', [
            'parented' => $parented,
            'coaches' => $coaches,
            'countries' => $countries,
            'districts' => $districts,
            'regions' => $regions,
        ]);
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

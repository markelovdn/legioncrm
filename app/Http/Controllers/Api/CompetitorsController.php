<?php

namespace App\Http\Controllers\Api;

use App\BusinessProcess\GetCompetitors;
use App\Filters\AthleteFilter;
use App\Filters\CompetitorFilter;
use App\Filters\UserFilter;
use App\Filters\WeightcategoryFilter;
use App\Http\Controllers\Controller;
use App\Models\Coach;
use App\Models\Competition;
use App\Models\Tehkval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompetitorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($competition_id, GetCompetitors $competitors)
    {
        $competition = Competition::where('id', $competition_id)->first();
        $competitors = $competitors->getCompetitorsApi($competition->id);

        if (!$competitors) {
            session()->flash('status', 'У вас нет участников на данном соревновании');
            return redirect(route('competitions.index'));
        }

        return json_encode($competitors);
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

<?php

namespace App\Http\Controllers\Api\V1;

use App\BusinessProcess\GetCompetitiors;
use App\Filters\CompetitorFilter;
use App\Filters\WeightcategoryFilter;
use App\Http\Controllers\Controller;
use App\Http\Controllers\User;
use App\Http\Requests\StoreCompetitorRequest;
use App\Models\Athlete;
use App\Models\Club;
use App\Models\Coach;
use App\Models\Competition;
use App\Models\Competitor;
use App\Models\Organization;
use App\Models\Sportkval;
use App\Models\Tehkval;
use App\Models\WeightCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CompetitorsController extends Controller
{

    private $competitor;
    public function __construct(Competitor $competitor){
        $this->competitor = $competitor;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($competition_id, Request $request, CompetitorFilter $CompetitorFilter, WeightcategoryFilter $weightFilter)
    {

//        $competitors = Competitor::filter($CompetitorFilter)->orderBy('created_at', 'desc')->get();
//        $weightcategories = WeightCategory::filter($weightFilter)->orderBy('agecategory_id')->get();
//        $competition = Competition::where('id', $request->input('competition_id'))->with('agecategories')->get();
//
//        return view('competitors.competitors',
//            [
//                'competitors'=>$competitors,
//                'competition'=>$competition,
//                'weightcategories'=>$weightcategories,
//            ]);

        $competition = Competition::where('id', $competition_id)->first();

        $competitors = $competition->competitors()
            ->with('athlete', 'agecategory', 'weightcategory', 'tehkvalgroup')
            ->get();

        return view('competitions.competitors', ['competition'=>$competition, 'competitors'=>$competitors]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($competition_id, GetCompetitiors $competitors)
    {
        $competitors = $competitors->getCompetitors(\App\Models\User::getRole());

        $tehkvals = Tehkval::all();
        $sportkvals = Sportkval::all();
        $organization = Organization::all();
        $coaches = Coach::all();
        $competition = Competition::find($competition_id);

        switch (\App\Models\User::getRole()){
            case('coach') :
                return view('competitors.addcompetitor_as_coach',
                    [
                        'tehkvals'=>$tehkvals,
                        'sportkvals'=>$sportkvals,
                        'organization'=>$organization,
                        'coaches'=>$coaches,
                        'competition'=>$competition,
                        'competitors'=>$competitors,
                    ]);
        }

        return view('competitors.addcompetitor',
            [
                'tehkvals'=>$tehkvals,
                'sportkvals'=>$sportkvals,
                'organization'=>$organization,
                'coaches'=>$coaches,
                'competition'=>$competition,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCompetitorRequest $request)
    {
        $request->validated();

        $competitor = Athlete::with('user', 'tehkval', 'sportkval')->where('id', $request->input('athlete_id'))->first();
        $competition = \Illuminate\Support\Facades\Request::input('competition_id');

        $agecategory_id = $this->competitor->getAgeCategory($competitor->user->date_of_birth);
        if(!$agecategory_id) {return back();}
        $weightcategory_id = $this->competitor->getWeightCategory($request->input('weight'), $competitor->gender, $competitor->user->date_of_birth);
        if(!$weightcategory_id) {return back();}
        $tehkvalgroup_id = $this->competitor->getTehKvalGroup($competitor->tehkval->max('id'), $competitor->user->date_of_birth);
        if(!$tehkvalgroup_id) {return back();}

        $competitor = new Competitor();
        $competitor->athlete_id = $request->input('athlete_id');
        $competitor->weight = $request->input('weight');
        $competitor->agecategory_id = $agecategory_id;
        $competitor->weightcategory_id = $weightcategory_id;
        $competitor->tehkvalgroup_id = $tehkvalgroup_id;

        $competitor->save();

        $competitor->competitions()->attach($competition);

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

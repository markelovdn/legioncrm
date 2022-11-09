<?php

namespace App\Http\Controllers\Api\V1;

use App\BusinessProcess\GetCompetitiors;
use App\Filters\CompetitorFilter;
use App\Filters\WeightcategoryFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompetitorRequest;
use App\Models\Athlete;
use App\Models\Coach;
use App\Models\User;
use App\Models\Competition;
use App\Models\Competitor;
use App\Models\Organization;
use App\Models\Sportkval;
use App\Models\Tehkval;
use App\Models\WeightCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CompetitorsController extends Controller
{

    private $competitor;
    public function __construct(Competitor $competitor){
        $this->competitor = $competitor;
    }

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


    public function create($competition_id, GetCompetitiors $competitors)
    {
        $tehkvals = Tehkval::all();
        $sportkvals = Sportkval::all();
        $organization = Organization::all();
        $coaches = Coach::all();
        $competition = Competition::find($competition_id);

        if (Auth::user()) {
        $competitors = $competitors->getCompetitors(\App\Models\User::getRole());

        switch (\App\Models\User::getRole()){
            case('coach') :
            case('parented') :
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

    public function store(StoreCompetitorRequest $request)
    {
        $request->validated();

        if (\App\Models\User::checkUserUnique($request->firstname, $request->secondname, $request->patronymic, $request->date_of_birth)) {
            $request->session()->flash('error_unique_user', 'Данные ФИО и дата рождения уже зарегистрированны в системе, войдите в личный кабинет и добавте спортсменов из личного кабинета, или свяжитесь с системным администратором');
            return back()->withInput();
        }

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

    public function store_as_new_user(StoreCompetitorRequest $request)
    {
        $request->validated();

        if (\App\Models\User::checkUserUnique($request->firstname, $request->secondname, $request->patronymic, $request->date_of_birth)) {
            $request->session()->flash('error_unique_user', 'Данные ФИО и дата рождения уже зарегистрированны в системе, войдите в личный кабинет и добавте спортсменов из личного кабинета, или свяжитесь с системным администратором');
            return back()->withInput();
        }

        $user = new User();

        $user->firstname = $request->firstname;
        $user->secondname = $request->secondname;
        $user->patronymic = $request->patronymic;
        $user->date_of_birth = $request->date_of_birth;
        $user->save();

        $athlete = new Athlete();
        $athlete->user_id = $user->id;
        $athlete->gender = $request->gender;
        $athlete->save();

        $competitor = Athlete::with('user', 'tehkval', 'sportkval')->where('id', $athlete->id)->first();
        $competition = \Illuminate\Support\Facades\Request::input('competition_id');

        $agecategory_id = $this->competitor->getAgeCategory($competitor->user->date_of_birth);
        if(!$agecategory_id) {return back();} //Не добавляется потомучто нет такого возраста на соревнованиях
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

    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}

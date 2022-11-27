<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompetitionRequest;
use App\Models\AgeCategory;
use App\Models\Competition;
use App\Models\CompetitionsRanksTitle;
use App\Models\Competitor;
use App\Models\Country;
use App\Models\District;
use App\Models\Organization;
use App\Models\Region;
use App\Models\Tehkval;
use App\Models\TehkvalGroup;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompetitionsController extends Controller
{

    private $competition;
    public function __construct(Competition $competition){
        $this->competition = $competition;
    }

    public function index()
    {
        $competitions = Competition::with('agecategories')->orderBy('id', 'DESC')->get();
        $competitors = Competitor::get();

        return view('competitions.competitions', [
            'competitions'=>$competitions,
            'competitors'=>$competitors]);
    }

    public function create()
    {
        $agecategories = AgeCategory::get();
        $tehkvalgroups = TehkvalGroup::get();
        $countries = Country::get();
        $districts = District::get();
        $regions = Region::get();
        $statuses = CompetitionsRanksTitle::get();
        $organizations = User::getUserOrganizations(auth()->user()->id);

        return view('competitions.addcompetition', [
            'agecategories' => $agecategories,
            'tehkvalgroups' => $tehkvalgroups,
            'countries' => $countries,
            'districts' => $districts,
            'regions' => $regions,
            'statuses' => $statuses,
            'organizations' => $organizations,
        ]);
    }

    public function store(StoreCompetitionRequest $request)
    {
        $request->validated();

        $competition = new Competition();

        $competition->title = $request->title;
        $competition->address = $request->address;
        $competition->date_start = $request->date_start;
        $competition->date_end = $request->date_end;
        $competition->status = $request->status;
        $competition->country_id = $request->country_id;
        $competition->district_id = $request->district_id;
        $competition->region_id = $request->region_id;
        $competition->linkreport = $request->linkreport;

        $competition->save();

        $comp = Competition::find($competition->id);

        $comp->agecategories()->detach();

        $comp->agecategories()->attach($request->agecategory);
        $comp->organizations()->attach($request->org_id);

        foreach ($request->agecategory as $id) {
            DB::table('tehkvals_groups')->insert([
                ['title'=>'Без групп',
                    'agecategory_id'=>$id,
                    'startgyp_id'=>1,
                    'finishgyp_id'=>14,
                    'competition_id'=>$comp->id
                ],
            ]);
        }


        $request->session()->flash('status', 'Соревнование успешно добавлено');

        return redirect('/competitions')->withInput();
    }

    public function show($id)
    {
        //данный метод дублирует показ всех спортсменов по соревнования, реализован в CompetitorsControler@index
    }

    public function edit($id)
    {
        $competition = Competition::with('agecategories', 'country', 'district', 'region', 'status', 'tehkvalsgroups')->find($id);

        $tehkvalgroups = TehkvalGroup::where('competition_id', $competition->id)->get();

        $agecategories = AgeCategory::get();
        $tehkvals = Tehkval::get();
        $countries = Country::get();
        $districts = District::get();
        $regions = Region::get();
        $statuses = CompetitionsRanksTitle::get();

        return view('competitions.editcompetition', [
            'competition' => $competition,
            'agecategories' => $agecategories,
            'tehkvalgroups' => $tehkvalgroups,
            'tehkvals' => $tehkvals,
            'countries' => $countries,
            'districts' => $districts,
            'regions' => $regions,
            'statuses' => $statuses,
        ]);

    }

    public function update(StoreCompetitionRequest $request, $id)
    {
        $request->validated();

        $competition = Competition::find($id);

        $competition->title = $request->title;
        $competition->address = $request->address;
        $competition->date_start = $request->date_start;
        $competition->date_end = $request->date_end;
        $competition->status = $request->status;
        $competition->country_id = $request->country_id;
        $competition->district_id = $request->district_id;
        $competition->region_id = $request->region_id;
        $competition->linkreport = $request->linkreport;

        $competition->save();

        $competition->agecategories()->detach();
        $competition->agecategories()->attach($request->agecategory);

        $request->session()->flash('status', 'Соревнование успешно изменено');

        return redirect('/competitions')->withInput();
    }

    public function destroy(Request $request, $id)
    {
        $competition = Competition::find($id);
        $competition->agecategories()->detach();
        $competition->organizations()->detach();

        $competition->delete();

        $request->session()->flash('status', 'Соревнование успешно удалены');

        return redirect('/competitions')->withInput();
    }

}

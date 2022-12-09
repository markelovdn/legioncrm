<?php

namespace App\Http\Controllers\Api\V1;

use App\BusinessProcess\GetCompetitiors;
use App\DomainService\RegistrationUserAs;
use App\Exports\CompetitorsExport;
use App\Filters\CompetitorFilter;
use App\Filters\WeightcategoryFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompetitorRequest;
use App\Models\Athlete;
use App\Models\Coach;
use App\Models\Role;
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
use Maatwebsite\Excel\Facades\Excel;

class CompetitorsController extends Controller
{

    public function index($competition_id, Request $request, CompetitorFilter $CompetitorFilter, WeightcategoryFilter $weightFilter, GetCompetitiors $competitors)
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

        $user = \auth()->user();

        $competition = Competition::where('id', $competition_id)->first();
        $athletes_parent = $competitors->getCompetitors(auth()->user()->id);

        if ($athletes_parent == null && $user->isParented($user) ||
            $athletes_parent != null && $user->isParented($user) && $athletes_parent->count() < 1) {
            session()->flash('status', 'Вы не добавляли спортсменов на данное мероприятие');
            return view('competitions.competitors', ['competition'=>$competition, 'competitors'=>$competitors]);
        }

        if($athletes_parent != null && $athletes_parent->count() >= 1 && $user->isParented($user)) {
            foreach ($athletes_parent as $athlete_parent) {
                $ids[] = $athlete_parent->id;
            }
            $competitors = $competition->competitors()
                ->with('athlete', 'agecategory', 'weightcategory', 'tehkvalgroup')
                ->whereIn('athlete_id', $ids)
                ->get();

            if($competitors->count() < 1) {
                session()->flash('status', 'Вы не добавляли спортсменов на данное мероприятие');
                return view('competitions.competitors', ['competition'=>$competition, 'competitors'=>$competitors]);
            }
            return view('competitions.competitors', ['competition'=>$competition, 'competitors'=>$competitors]);
        }

            $competitors = $competition->competitors()
                ->with('athlete', 'agecategory', 'weightcategory', 'tehkvalgroup')
                ->get();

        return view('competitions.competitors', ['competition'=>$competition, 'competitors'=>$competitors]);
    }


    public function create($competition_id, GetCompetitiors $competitors, RegistrationUserAs $userAs)
    {
        if (\auth()->user()->isParented(\auth()->user()) && $competitors->getCompetitors(auth()->user()->id)->count() < 1) {
            return redirect($userAs->registrationUserAs(Role::ROLE_PARENTED, \auth()->user()->id));
        }

        $tehkvals = Tehkval::all();
        $sportkvals = Sportkval::all();
        $organization = Organization::all();
        $coaches = Coach::with('user')->get();
        $competition = Competition::find($competition_id);
        $competitors = $competitors->getCompetitors(auth()->user()->id);

        if ($competitors && $competitors->count() >= 1) {
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

    public function store(StoreCompetitorRequest $request)
    {
        $request->validated();

        $athlete = Athlete::with('user', 'tehkval', 'sportkval')->where('id', $request->input('athlete_id'))->first();

        if (Competition::find($request->competition_id) == null)
        {
            throw new \Exception('Не найдено соревнования');
        }

        $agecategory_id = Competitor::getAgeCategory($athlete->user->date_of_birth);
        if(!$agecategory_id) {return back();}
        $weightcategory_id = Competitor::getWeightCategory($request->input('weight'), $athlete->gender, $athlete->user->date_of_birth);
        if(!$weightcategory_id) {return back();}
        $tehkvalgroup_id = Competitor::getTehKvalGroup($athlete->tehkval->max('id'), $athlete->user->date_of_birth);
        if(!$tehkvalgroup_id) {return back();}

        if (!Competitor::checkUniqueCompetitorWeightCategory(
            $athlete->id, $agecategory_id, $weightcategory_id, $tehkvalgroup_id, $request->competition_id
        )) {
            session()->flash('error_unique_competitor', 'Данный спорстмен уже заявлен в весовой категории');
            return back()->withInput();
        }

        $competitor = new Competitor();
        $competitor->athlete_id = $request->input('athlete_id');
        $competitor->weight = $request->input('weight');
        $competitor->agecategory_id = $agecategory_id;
        $competitor->weightcategory_id = $weightcategory_id;
        $competitor->tehkvalgroup_id = $tehkvalgroup_id;

        $competitor->save();

        $competitor->competitions()->attach($request->competition_id);

        session()->flash('status', 'Спортсмен успешно добавлен на соревнования');

        return back();

    }

    public function store_as_new_user(StoreCompetitorRequest $request)
    {
        $request->validated();

        if (Competition::find($request->competition_id) == null)
        {
            throw new \Exception('Не найдено соревнования');
        }

        if (!\App\Models\User::checkUserUnique($request->firstname, $request->secondname, $request->patronymic, $request->date_of_birth)) {
            return back()->withInput();
        }

        $agecategory_id = Competitor::getAgeCategory($request->date_of_birth);
        if(!$agecategory_id) {
            return back()->withInput();
        }

        $weightcategory_id = Competitor::getWeightCategory($request->input('weight'), $request->gender, $request->date_of_birth);
        if(!$weightcategory_id) {
            return back()->withInput();
        }

        $tehkvalgroup_id = Competitor::getTehKvalGroup($request->tehkval_id, $request->date_of_birth);
        if(!$tehkvalgroup_id) {
            return back()->withInput();
        }

        $user = new User();
        $user->firstname = $request->firstname;
        $user->secondname = $request->secondname;
        $user->patronymic = $request->patronymic;
        $user->date_of_birth = $request->date_of_birth;
        $user->save();
        $role = Role::where('code', 'athlete')->get();

        $user->role()->attach($role);

        $coaches = Coach::find($request->coach_id);

        if($coaches->code == $request->coach_code) {
            $athlete = new Athlete();
            $athlete->user_id = $user->id;
            $athlete->gender = $request->gender;
            $athlete->status = 1;
            $athlete->save();

            $athlete->coaches()->attach($coaches, ['coach_type' => 1]);
        }
        else{
            $request->session()->flash('status', 'Не верный код тренера');
            return back()->withInput();
        }

        $athlete->tehkval()->attach($request->tehkval_id);
        $athlete->sportkval()->attach($request->sportkval_id);

        if (!Competitor::checkUniqueCompetitorWeightCategory(
            $athlete->id, $agecategory_id, $weightcategory_id, $tehkvalgroup_id, $request->competition_id
        )) {
            return back()->withInput();
        }

        $competitor = new Competitor();
        $competitor->athlete_id = $athlete->id;
        $competitor->weight = $request->input('weight');
        $competitor->agecategory_id = $agecategory_id;
        $competitor->weightcategory_id = $weightcategory_id;
        $competitor->tehkvalgroup_id = $tehkvalgroup_id;
        $competitor->save();

        $competitor->competitions()->attach($request->competition_id);


        return redirect('competitions/'.\Illuminate\Support\Facades\Request::input('competition_id').'/competitors/');

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $competitor = Competitor::with('athlete')->find($id);
        $coach_id = Athlete::with('coaches')->has('coaches')->where('id', $competitor->athlete_id)->first();
        $tehkvals = Tehkval::all();
        $sportkvals = Sportkval::all();
        $competition_id = \Illuminate\Support\Facades\Request::input('competition_id');

        return view('competitors.editcompetitor',
            [
                'tehkvals'=>$tehkvals,
                'sportkvals'=>$sportkvals,
                'competitor'=>$competitor,
                'coach_id'=>$coach_id,
                'competition_id'=>$competition_id,
            ]);
    }

    public function update(StoreCompetitorRequest $request, $id)
    {
        $request->validated();

        if (!Competitor::isCoachAthlete($id)){
            throw new \Exception('Вы не можете редактировать данного спортсмена');
        }

        $competitor = Competitor::with('athlete')->where('athlete_id', $id)->first();
        $user = User::find($competitor->athlete->user->id);

        $competition = Competitor::with('competitions')->has('competitions')->first();

        $agecategory_id = Competitor::getAgeCategory($request->date_of_birth);
        if(!$agecategory_id) {return back();}
        $weightcategory_id = Competitor::getWeightCategory($request->input('weight'), $request->gender, $request->date_of_birth);
        if(!$weightcategory_id) {return back();}
        $tehkvalgroup_id = Competitor::getTehKvalGroup($competitor->athlete->tehkval->max('id'), $request->date_of_birth);
        if(!$tehkvalgroup_id) {return back();}

        if ($request->weight != $competitor->weight) {
            if (Competitor::checkUniqueCompetitorWeightCategory($competitor->athlete->id,
                $agecategory_id, $weightcategory_id, $tehkvalgroup_id, $competition->id)) {

                $competitor->weight = $request->weight;
                $competitor->save();

            } else {
                session()->flash('error_unique_competitor', 'Данный спорстмен уже заявлен в весовой категории');
                return back()->withInput();
            }
        }

        $competitor->agecategory_id = $agecategory_id;
        $competitor->weightcategory_id = $weightcategory_id;
        $competitor->tehkvalgroup_id = $tehkvalgroup_id;
        $competitor->save();

        $user->firstname = $request->firstname;
        $user->secondname = $request->secondname;
        $user->patronymic = $request->patronymic;
        $user->date_of_birth = $request->date_of_birth;
        $user->save();

        return redirect('competitions/' . $request->input('competition_id') . '/competitors/');

    }

    public function destroy($id, Request $request)
    {
        if (!Competitor::isCoachAthlete($id)){
            throw new \Exception('Вы не можете редактировать данного спортсмена');
        }

        $competitor = Competitor::find($id);
        $competitor->competitions()->detach();

        $competitor->delete();

        session()->flash('status', 'Спортсмен успешно удален с соревнований');

        return redirect('/competitions/'.$request->input('competition_id').'/competitors')->withInput();
    }

    public function competitorsExport()
    {
        return Excel::download(new CompetitorsExport, 'competitors.xlsx');
    }
}

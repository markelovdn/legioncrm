<?php

namespace App\Http\Controllers;

use App\BusinessProcess\GetCompetitors;
use App\BusinessProcess\UploadFile;
use App\DomainService\AttachOrganization;
use App\DomainService\RegistrationUserAs;
use App\Exports\CompetitorsExport;
use App\Filters\AthleteFilter;
use App\Filters\CompetitorFilter;
use App\Filters\UserFilter;
use App\Filters\WeightcategoryFilter;
use App\Http\Requests\StoreCompetitorRequest;
use App\Models\AgeCategory;
use App\Models\Athlete;
use App\Models\Coach;
use App\Models\Competition;
use App\Models\Competitor;
use App\Models\Organization;
use App\Models\Role;
use App\Models\Sportkval;
use App\Models\Tehkval;
use App\Models\TehkvalGroup;
use App\Models\User;
use App\Models\WeightCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class CompetitorsController extends Controller
{

    public function index($competition_id, Request $request, CompetitorFilter $CompetitorFilter, WeightcategoryFilter $weightFilter,
                          GetCompetitors $competitors, UserFilter $userFilter, AthleteFilter $athleteFilter)
    {
//        $user = \auth()->user()->id;
//        $tehkvals = Tehkval::get();
//        $coaches = Coach::with('user')->get();
//        $coach = Coach::with('user')->where('user_id', $user)->first();
        $competition = Competition::where('id', $competition_id)->first();
        $isOwner = Competition::getOwner($competition->id);

        if (!$isOwner) {
            $isOwner = 'false';
        }

        $user = User::with('coach', 'parented', 'referee')->where('id', \auth()->user()->id)->first();
//        $agecategories = $competition->agecategories()->get();
//        $weightcategories = DB::table('weight_categories')->where('agecategory_id', $request->agecategory_id)->get();
//        $tehkvalgroups = DB::table('tehkvals_groups')
//            ->where('agecategory_id', $request->agecategory_id)
//            ->where('competition_id', $competition_id)
//            ->get();
//        $competitors = $competitors->getCompetitors($user, $competition->id, $CompetitorFilter, $weightFilter, $athleteFilter);
//
//        if (!$competitors) {
//            session()->flash('status', 'У вас нет участников на данном соревновании');
//            return redirect(route('competitions.index'));
//        }

        return view('competitions.competitors', ['competition'=>$competition,
                'isOwner'=> $isOwner,
                'user'=> $user,
//            'competitors' => $competitors, 'tehkvals' => $tehkvals,
//            'coaches' => $coaches,
//            'coach' => $coach,
//            'agecategories' => $agecategories,
//            'weightcategories'=>$weightcategories,
//            'tehkvalgroups' => $tehkvalgroups
            ]);
    }


    public function create($competition_id, GetCompetitors $competitors, RegistrationUserAs $userAs, CompetitorFilter $CompetitorFilter,
                           WeightcategoryFilter $weightFilter, AthleteFilter $athleteFilter)
    {
        $competition = Competition::find($competition_id);
        $competitors = $competitors->getCompetitors(auth()->user()->id, $competition->id, $CompetitorFilter, $weightFilter, $athleteFilter);
        $tehkvals = Tehkval::all();
        $sportkvals = Sportkval::all();
        $organization = Organization::all();
        $coaches = Coach::with('user')->get();
        $weightCategories = WeightCategory::get();

        if (\auth()->user()->isParented(\auth()->user()) && $competitors->count() < 1) {
            return redirect($userAs->registrationUserAs(Role::ROLE_PARENTED, \auth()->user()->id));
        }

        if (!$competitors) {
            $competitors = [];
        }

        return view('competitors.addcompetitor',
            [
                'tehkvals'=>$tehkvals,
                'sportkvals'=>$sportkvals,
                'organization'=>$organization,
                'coaches'=>$coaches,
                'competition'=>$competition,
                'competitors'=>$competitors,
                'weightCategories'=>$weightCategories
            ]);
    }

    public function store(StoreCompetitorRequest $request)
    {
        $request->validated();
        $competitor = new Competitor();

        $athlete = Athlete::with('user', 'tehkval', 'sportkval')->where('id', $request->input('athlete_id'))->first();

        if (Competition::find($request->competition_id) == null)
        {
            throw new \Exception('Не найдено соревнования');
        }

        $agecategory_id = $competitor->getAgeCategory($athlete->user->date_of_birth);
        if(!$agecategory_id) {
            session()->flash('error_age', 'Нет подходящего возраста для данных соревнований');
            return back();
        }
        $weightcategory_id = $competitor->getWeightCategory($request->input('weight'), $athlete->gender, $athlete->user->date_of_birth);
        if(!$weightcategory_id) {
            session()->flash('error_weight', 'Нет подходящей весовой категории для данных соревнований');
            return back();
        }
        $tehkvalgroup_id = $competitor->getTehKvalGroup($athlete->tehkval->max('id'), $athlete->user->date_of_birth, $request->competition_id);
        if(!$tehkvalgroup_id) {
            session()->flash('error_tehkval', 'Нет подходящей группы по технической квалификации для данных соревнований');
            return back();
        }

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

        return redirect(route('competitions.competitors.index',[$request->competition_id]));

    }

    public function store_as_new_user(StoreCompetitorRequest $request)
    {
        $request->validated();
        $competitor = new Competitor();

        if (Competition::find($request->competition_id) == null)
        {
            throw new \Exception('Не найдено соревнования');
        }

        if (!Auth::user()->checkUserUnique($request->firstname, $request->secondname, $request->patronymic, $request->date_of_birth)) {
            return back()->withInput();
        }

        $agecategory_id = $competitor->getAgeCategory($request->date_of_birth);
        if(!$agecategory_id) {
            session()->flash('error_age', 'Спортсмен данного возраста пока не может принимать участи в соревнованиях по спаррингу');
            return back()->withInput();
        }

        $weightcategory_id = $competitor->getWeightCategory($request->input('weight'), $request->gender, $request->date_of_birth);
        if(!$weightcategory_id) {
            return back()->withInput();
        }

        $tehkvalgroup_id = $competitor->getTehKvalGroup($request->tehkval_id, $request->date_of_birth, $request->competition_id);
        if(!$tehkvalgroup_id) {
            session()->flash('error_tehkval', 'Нет подходящей группы по технической квалификации для данных соревнований');
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

        if ($request->hasFile('photo')) {
            $UploadFile = new UploadFile();
            $path_scanlink = $UploadFile->uploadFile($user->id, $user->secondname,$user->firstname, 'photo', $request->file('photo'));
        }

        $user_coach = User::where('id', \auth()->user()->id)->with('coach', 'organizations')->first();

            $athlete = new Athlete();
            $athlete->user_id = $user->id;
            $athlete->gender = $request->gender;
            $athlete->photo =  $path_scanlink ?? null;
            $athlete->status = Athlete::ACTIVE;
            $athlete->save();

            $athlete->coaches()->attach($user_coach->coach, ['coach_type' => Coach::REAL_COACH]);

        $athlete->tehkval()->attach($request->tehkval_id, ['organization_id' => $user_coach->organizations->first()->id]);
        $athlete->sportkval()->attach($request->sportkval_id);

        $AttachOrganization = new AttachOrganization();

        $AttachOrganization->attachOrganization(Role::ROLE_ATHLETE,  $user->id, $user_coach->coach->code);

        if (!Competitor::checkUniqueCompetitorWeightCategory(
            $athlete->id, $agecategory_id, $weightcategory_id, $tehkvalgroup_id, $request->competition_id
        )) {
            return back()->withInput();
        }

//        $competitor = new Competitor();
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
        return redirect('/');
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

        $competition = Competition::where('id', $request->competition_id)->first();

        if (!Competitor::isCoachAthlete($id) && !Competition::getOwner($competition->id)){
            throw new \Exception('Вы не можете редактировать данного спортсмена');
        }

        $competitor = $competition->competitors()->where('athlete_id', $id)->first();

        if ($request->place) {
            $competitor->count_winner = $request->count_winner;
            $competitor->place = $request->place;
            $competitor->save();
            return back();
        }

        $agecategory_id = Competitor::getAgeCategory($request->date_of_birth);
        if(!$agecategory_id) {
            session()->flash('error_age', 'Нет подходящего возраста для данных соревнований');
            return back();
        }
        $weightcategory_id = Competitor::getWeightCategory($request->input('weight'), $request->gender, $request->date_of_birth);
        if(!$weightcategory_id) {
            session()->flash('error_weight', 'Нет подходящей весовой категории для данных соревнований');
            return back();
        }
        $tehkvalgroup_id = Competitor::getTehKvalGroup($request->tehkval_id, $request->date_of_birth, $request->competition_id);
        if(!$tehkvalgroup_id) {
            session()->flash('error_tehkval', 'Нет подходящей группы по технической квалификации для данных соревнований');
            return back();
        }

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
        $competitor->count_winner = $request->count_winner;
        $competitor->place = $request->place;
        $competitor->save();

        return redirect('competitions/' . $request->input('competition_id') . '/competitors/');
    }

    public function destroy($id, Request $request)
    {
        //TODO:Добавить всплвающее окно с подтверждением
        $competitor = Competitor::with('athlete')->find($id);

        if (!Competitor::isCoachAthlete($competitor->athlete_id) && !Competition::getOwner($request->competition_id)){
            throw new \Exception('Вы не можете редактировать данного спортсмена');
        }

        $competitor->competitions()->detach();

        $competitor->delete();

        session()->flash('status', 'Спортсмен успешно удален с соревнований');

        return redirect('/competitions/'.$request->input('competition_id').'/competitors')->withInput();
    }

    public function competitorsExport(Request $request)
    {
        $competition_id = $request->competition_id;
        $agecategory_id = $request->agecategory_id;
        $tehkvalgroup_id = $request->tehkvalgroup_id;

        if ($agecategory_id && !$tehkvalgroup_id) {
            $agecategory = AgeCategory::where('id', $agecategory_id)->first();
            return Excel::download(new CompetitorsExport, $agecategory->title.'.xlsx');
        }

        if ($tehkvalgroup_id) {
            $group = TehkvalGroup::with('agecategory')->where('id', $tehkvalgroup_id)
                ->where('agecategory_id', $agecategory_id)
                ->first();

            return Excel::download(new CompetitorsExport, $group->agecategory->title.'-'.$group->title.'.xlsx');
        }

        return Excel::download(new CompetitorsExport, 'Все участники.xlsx');
    }

    public function addCompetitorsToPoomsaeTablo() {

        $competition = Competition::where('id', 3)->first();
        $competitors = $competition->competitors()
            ->with('athlete', 'agecategory', 'weightcategory', 'tehkvalgroup')
            ->orderBy('id', 'DESC')
            ->get();
        return view('competitions.poomsae.poomsae-competitor', ['competitors' => $competitors]);
    }
}

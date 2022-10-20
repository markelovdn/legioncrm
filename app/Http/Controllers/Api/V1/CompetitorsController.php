<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\CompetitorFilter;
use App\Filters\WeightcategoryFilter;
use App\Http\Controllers\Controller;
use App\Models\Club;
use App\Models\Coach;
use App\Models\Competition;
use App\Models\Competitor;
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
    public function index(Request $request, CompetitorFilter $CompetitorFilter, WeightcategoryFilter $weightFilter)
    {

        $competitors = Competitor::filter($CompetitorFilter)->orderBy('created_at', 'desc')->get();
        $weightcategories = WeightCategory::filter($weightFilter)->orderBy('agecategory_id')->get();
        $competition = Competition::where('id', $request->input('competition_id'))->with('agecategories')->get();
        $pair = $this->setNumLot($request);

        return view('competitors.competitors',
            [
                'competitors'=>$competitors,
                'competition'=>$competition,
                'weightcategories'=>$weightcategories,
                'pair'=>$pair
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $tehkvals = Tehkval::all();
        $sportkvals = Sportkval::all();
        $clubs = Club::all();
        $coachs = Coach::all();
        $competition = Competition::find($request->input('competition_id'), 'name');


        return view('competitors.addcompetitor',
            [
                'tehkvals'=>$tehkvals,
                'sportkvals'=>$sportkvals,
                'clubs'=>$clubs,
                'coaches'=>$coachs,
                'request'=>$request,
                'competition'=>$competition,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'gender' => ['required', 'string', 'max:7'],
            'secondname' => ['required', 'string', 'max:40'],
            'firstname' => ['required', 'string', 'max:20'],
            'patronymic' => ['required', 'string', 'max:40'],
            'date_of_birth' => ['required'],
            'weight' => ['required', 'numeric', 'max:150', 'min:15'],
            'coach_code' => ['required', 'numeric'],
            'sportkval_id' => ['required', 'numeric'],
            'coach_id' => ['required', 'numeric'],
        ]);

        $coach = Coach::where('code', $request->input('coach_code'))->exists();

        try {
            if($coach) {
                $competitor = new Competitor();

                $competitor->gender = $request->gender;
                $competitor->firstname = $request->firstname;
                $competitor->secondname = $request->secondname;
                $competitor->patronymic = $request->patronymic;
                $competitor->date_of_birth = $request->date_of_birth;
                $competitor->weight = $request->weight;
                $competitor->tehkval_id = $request->tehkval_id;
                $competitor->sportkval_id = $request->sportkval_id;
                $competitor->coach_id = $request->coach_id;
                $competitor->competition_id = $request->competition_id;
                $competitor->agecategory_id = $this->competitor->getAgeCategory($request);
                $competitor->weightcategory_id = $this->competitor->getWeightCategory($request);
                $competitor->tehkvalgroup_id = $this->competitor->getTehKvalGroup($request);

                $competitor->save();
                $request->session()->flash('status', 'Спортсмен добавлен на мероприятие');
            }
            else{
                $request->session()->flash('status', 'Неверный код тренера');
                return redirect('/addcompetitor?competition_id='.$request->competition_id)->withInput();
            }
        } catch (\Exception $exception) {
            $request->session()->flash('error', 'Нет подходящей весовой категории для данного возраста и веса спортсмена. Пожалуйста обратитесь к тренеру или организаторам мероприятия');
            return redirect('/addcompetitor?competition_id='.$request->competition_id)->withInput();
        }

        return redirect('/competitors?competition_id='.$request->competition_id);

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

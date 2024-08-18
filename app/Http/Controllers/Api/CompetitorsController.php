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
use App\Models\Competitor;
use App\Models\Tehkval;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;

class CompetitorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(GetCompetitors $competitors, CompetitorFilter $CompetitorFilter, AthleteFilter $athleteFilter)
    {
        $competitors = $competitors->getCompetitorsApi($CompetitorFilter, $athleteFilter);

        if (!$competitors) {
            session()->flash('status', 'У вас нет участников на данном соревновании');
            return false;
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
    public function updateResult(Request $request, $id)
    {
        $request = $request->request->all();
        $competitor = Competitor::find($id);

        $competitor->count_winner = $request['params']['count_winner'];
        $competitor->place = $request['params']['place'];

        $competitor->save();

        return $competitor;
    }

    public function updateData(Request $request, $id)
    {
        $request = $request->request->all();
        $competition = Competition::where('id', $request['params']['competition_id'])->first();

        if (!Competitor::isCoachAthlete($id) && !Competition::getOwner($competition->id)){
            throw new \Exception('Вы не можете редактировать данного спортсмена');
        }

        $competitor = Competitor::find($id);

        $agecategory_id = $competitor->getAgeCategory($request['params']['date_of_birth']);
        if(!$agecategory_id) {
            return json_encode('Нет подходящего возраста для данных соревнований');
        }
        $weightcategory_id = $competitor->getWeightCategory($request['params']['weight'], $request['params']['gender'], $request['params']['date_of_birth']);
        if(!$weightcategory_id) {
            return json_encode('Нет подходящей весовой категории для данных соревнований');
        }
        $tehkvalgroup_id = $competitor->getTehKvalGroup($request['params']['tehkval_id'], $request['params']['date_of_birth'], $request['params']['competition_id']);
        if(!$tehkvalgroup_id) {
            return json_encode('Нет подходящей группы по технической квалификации для данных соревнований');
        }

        if ($request['params']['weight'] != $competitor->weight) {
            if ($competitor->checkUniqueCompetitorWeightCategory($competitor->athlete->id,
                $agecategory_id, $weightcategory_id, $tehkvalgroup_id, $competition->id)) {

                $competitor->weight = $request['params']['weight'];
                $competitor->save();

            } else {
                return json_encode('Данный спорстмен уже заявлен в весовой категории');
            }
        }

        $competitor->agecategory_id = $agecategory_id;
        $competitor->weightcategory_id = $weightcategory_id;
        $competitor->tehkvalgroup_id = $tehkvalgroup_id;
        $competitor->save();

        $competitor = Competitor::with('athlete','agecategory', 'weightcategory', 'tehkvalgroup')->find($id);

        return $competitor;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Competitor::destroy($id);

        return true;
    }
}

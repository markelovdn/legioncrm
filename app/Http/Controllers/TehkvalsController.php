<?php

namespace App\Http\Controllers;

use App\BusinessProcess\uploadFile;
use App\Models\Athlete;
use App\Models\Competitor;
use App\Models\Organization;
use App\Models\Tehkval;
use App\Models\TehkvalGroup;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TehkvalsController extends Controller
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
    public function store(Request $request)
    {
        $athlete = Athlete::with('user')->find($request->athlete_id);
        $tehkval = Tehkval::find($request->tehkval_id);

        if (Tehkval::hasAthlete($request->tehkval_id, $athlete->id)) {
            session()->flash('error', 'Данная техническая квалификация уже присвоена спортсмену');
            return back();
        }

        if ($request->hasFile('sertificate_link')) {
            $path_scanlink = uploadFile::uploadFile($athlete->user->id,
                $athlete->user->secondname, $athlete->user->firstname, 'belt_sertificate_'.$tehkval->belt_color, $request->file('sertificate_link'));
        }

        $athlete->tehkval()->attach($tehkval->id,
            ['organization_id' => Organization::getOrganizationId(),
             'created_at' => Carbon::now(),
             'sertificatenum' => $request->input('sertificatenum'),
             'sertificate_link' => $path_scanlink
            ]);

//        //TODO:Убрать эту хрень
        $tehkvalgroup = TehkvalGroup::
        whereRaw('agecategory_id = '.Competitor::getAgeCategory($athlete->user->date_of_birth).
            ' and finishgyp_id >= '.$tehkval->id.' and competition_id = '.$request->competition_id)
            ->first();

        $competitor = Competitor::find($request->competitor_id);
        $competitor->tehkvalgroup_id = $tehkvalgroup->id;

        $competitor->save();

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
    public function destroy(Request $request, $id)
    {
//        TODO:сделать проверку на удаление посленего
        $athlete = Athlete::where('id', $request->input('athlete_id'))->first();

        $athlete->tehkval()->detach($id);

        return back();
    }
}

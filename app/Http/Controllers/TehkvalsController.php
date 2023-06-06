<?php

namespace App\Http\Controllers;

use App\BusinessProcess\UploadFile;
use App\Models\Athlete;
use App\Models\Competitor;
use App\Models\Organization;
use App\Models\Tehkval;
use App\Models\TehkvalGroup;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TehkvalsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return json_encode(Tehkval::get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect('/');
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
        $organization = new Organization();

        if ($tehkval->hasAthlete($request->tehkval_id, $athlete->id)) {
            session()->flash('error', 'Данная техническая квалификация уже присвоена спортсмену');
            return back();
        }

        if ($request->hasFile('sertificate_link')) {
            $UploadFile = new UploadFile();
                $path_scanlink = $UploadFile->uploadFile($athlete->user->id,
                $athlete->user->secondname, $athlete->user->firstname, 'belt_sertificate_'.$tehkval->belt_color, $request->file('sertificate_link'));
        } else {
            $path_scanlink = '';
        }

        if (count($athlete->getTehkval($athlete->id)) < 2 && $athlete->getTehkval($athlete->id)->min()->tehkval_id == Tehkval::NOT) {
            DB::table('athlete_tehkval')
                ->where('athlete_id', $athlete->id)
                ->update([
                    'tehkval_id' => $tehkval->id,
                    'organization_id' => $organization->getOrganizationId(),
                    'created_at' => Carbon::now(),
                    'sertificatenum' => $request->input('sertificatenum'),
                    'sertificate_link' => $path_scanlink
                ]);
            session()->flash('status',
                'Спортсмену '.$athlete->user->secondname.' '.$athlete->user->firstname.' '.
                'добавлена техническая квалификация '.$tehkval->title);

            return redirect();
        }

        $athlete->tehkval()->attach($tehkval->id,
            ['organization_id' => $organization->getOrganizationId(),
             'created_at' => Carbon::now(),
             'sertificatenum' => $request->input('sertificatenum'),
             'sertificate_link' => $path_scanlink
            ]);

//        //TODO:Убрать эту хрень
        if ($request->competition_id) {
            $tehkvalgroup = TehkvalGroup::
            whereRaw('agecategory_id = '.Competitor::getAgeCategory($athlete->user->date_of_birth).
                ' and finishgyp_id >= '.$tehkval->id.' and competition_id = '.$request->competition_id)
                ->first();

            $competitor = Competitor::find($request->competitor_id);
            $competitor->tehkvalgroup_id = $tehkvalgroup->id;

            $competitor->save();
        }
        session()->flash('status',
            'Спортсмену '.$athlete->user->secondname.' '.$athlete->user->firstname.' '.
            'добавлена техническая квалификация '.$tehkval->title);

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
        return redirect('/');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return redirect('/');
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
        return redirect('/');
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
        $tehkval = Tehkval::where('id', $id)->first();

        if (count(Athlete::getTehkval($athlete->id)) < 2) {
            session()->flash('error', 'Невозможно удалить единственную запись по технической квалификации');
            return back();
        }

        $athlete->tehkval()->detach($id);

        session()->flash('status',
            'Спортсмену '.$athlete->user->secondname.' '.$athlete->user->firstname.' '.
            'удалена техническая квалификация '.$tehkval->title);

        return back();
    }
}

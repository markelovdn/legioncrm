<?php

namespace App\Http\Controllers;

use App\BusinessProcess\GetAttestationAthletes;
use App\BusinessProcess\GetCompetitors;
use App\DomainService\RegistrationUserAs;
use App\Filters\UserFilter;
use App\Http\Requests\AttestationAthletesRequest;
use App\Models\Athlete;
use App\Models\Attestation;
use App\Models\Coach;
use App\Models\Organization;
use App\Models\Role;
use App\Models\Sportkval;
use App\Models\Tehkval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AttestationAthletesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($attestation_id,
                          Request $request,
                          GetAttestationAthletes $attestationAthletes,
                          UserFilter $userFilter)
    {

        $user = \auth()->user();
        $tehkvals = Tehkval::get();

        $attestation = Attestation::where('id', $attestation_id)->first();
        $athletes = $attestationAthletes->getAthletes(auth()->user()->id);

        if ($athletes == null && $user->isParented($user) ||
            $athletes != null && $user->isParented($user) && $athletes->count() < 1) {
            session()->flash('status', 'Вы не добавляли спортсменов на данное мероприятие');
            return view('attestations.attestation-athletes',
                ['attestation '=>$attestation , 'athletes'=>$athletes, 'tehkvals'=>$tehkvals]);
        }

        if($athletes!= null && $athletes->count() >= 1 && $user->isParented($user)) {
            foreach ($athletes as $athlete_parent) {
                $ids[] = $athletes->id;
            }
            $athletes = $attestation->athletes()
                ->whereIn('athlete_id', $ids)
                ->get();

            if($athletes->count() < 1) {
                session()->flash('status', 'Вы не добавляли спортсменов на данное мероприятие');
                return view('attestations.attestation-athletes', ['attestation'=>$attestation, 'athletes'=>$athletes]);
            }
            return view('attestations.attestation-athletes', ['attestation'=>$attestation, 'athletes'=>$athletes, 'tehkvals'=>$tehkvals]);
        }

        $athletes = $attestation->athletes()
            ->orderBy('id', 'DESC')
            ->get();

        return view('attestations.attestation-athletes', ['attestation'=>$attestation, 'athletes'=>$athletes, 'tehkvals'=>$tehkvals]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($attestation_id, GetAttestationAthletes $attestationAthletes, RegistrationUserAs $userAs)
    {
        $tehkvals = Tehkval::all();
        $sportkvals = Sportkval::all();
        $organization = Organization::all();
        $coaches = Coach::with('user')->get();
        $attestation = Attestation::find($attestation_id);
        $attestationAthletes = $attestationAthletes->getAthletes(auth()->user()->id);

        if ($attestationAthletes && $attestationAthletes->count() >= 1) {
            return view('attestations.addathletes',
                [
                    'tehkvals'=>$tehkvals,
                    'sportkvals'=>$sportkvals,
                    'organization'=>$organization,
                    'coaches'=>$coaches,
                    'attestation'=>$attestation,
                    'attestationAthletes'=>$attestationAthletes,
                ]);
        }

        return back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttestationAthletesRequest $request)
    {
        $request->validated();

        $athlete = Athlete::where('id', $request->input('athlete_id'))->first();

        if (Attestation::find($request->attestation_id) == null)
        {
            throw new \Exception('Не найдено аттестации');
        }

        if (Attestation::hasAthlete($request->attestation_id, $athlete->id)) {
            session()->flash('status', 'Данный спортсмен уже добавлен на аттестацию');
            return back();
        }

        $athlete->attestations()->attach($request->attestation_id, ['approve'=> Attestation::APPROVE]);

        session()->flash('status', 'Спортсмен успешно добавлен на аттестацию');

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

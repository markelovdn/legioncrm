<?php

namespace App\Http\Controllers;

use App\BusinessProcess\GetAttestationAthletes;
use App\BusinessProcess\GetCompetitors;
use App\DomainService\RegistrationUserAs;
use App\Exports\AttestationAthletesExport;
use App\Filters\UserFilter;
use App\Http\Requests\AttestationAthletesRequest;
use App\Models\Athlete;
use App\Models\Attestation;
use App\Models\Coach;
use App\Models\Organization;
use App\Models\Payment;
use App\Models\Role;
use App\Models\Sportkval;
use App\Models\Tehkval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AttestationAthletesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($attestation_id, Request $request, GetAttestationAthletes $attestationAthletes, UserFilter $userFilter)
    {
        $user = \auth()->user();
        $tehkvals = Tehkval::get();

        $attestation = Attestation::where('id', $attestation_id)->first();
        $athletes = $attestationAthletes->getAthletes(auth()->user()->id);
        //        $countTehkvals = $attestationAthletes->getCountTehkvals($attestation->id);

        if (
            $athletes == null && $user->isCoach($user) ||
            $athletes != null && $user->isCoach($user) && $athletes->count() < 1
        ) {
            session()->flash('status', 'Вы не добавляли спортсменов на данное мероприятие');
            return view(
                'attestations.attestation-athletes',
                ['attestation ' => $attestation, 'athletes' => $athletes, 'tehkvals' => $tehkvals]
            );
        }

        if ($athletes != null && $athletes->count() >= 1 && $user->isCoach($user)) {
            foreach ($athletes as $athlete_parent) {
                $ids[] = $athlete_parent->id;
            }
            $athletes = $attestation->athletes()
                ->whereIn('athlete_id', $ids)
                ->get();

            if ($athletes->count() < 1) {
                session()->flash('status', 'Вы не добавляли спортсменов на данное мероприятие');
                return view('attestations.attestation-athletes', ['attestation' => $attestation, 'athletes' => $athletes, 'attestationAthletes' => $attestationAthletes]);
            }
            return view('attestations.attestation-athletes', ['attestation' => $attestation, 'athletes' => $athletes, 'tehkvals' => $tehkvals, 'attestationAthletes' => $attestationAthletes]);
        }

        if (
            $athletes == null && $user->isCoach($user) ||
            $athletes != null && $user->isCoach($user) && $athletes->count() < 1
        ) {
            session()->flash('status', 'Вы не добавляли спортсменов на данное мероприятие');
            return view(
                'attestations.attestation-athletes',
                ['attestation ' => $attestation, 'athletes' => $athletes, 'tehkvals' => $tehkvals, 'attestationAthletes' => $attestationAthletes]
            );
        }

        if ($athletes != null && $athletes->count() >= 1 && $user->isParented($user)) {
            foreach ($athletes as $athlete_parent) {
                $ids[] = $athlete_parent->id;
            }
            $athletes = $attestation->athletes()
                ->whereIn('athlete_id', $ids)
                ->get();

            if ($athletes->count() < 1) {
                session()->flash('status', 'Вы не добавляли спортсменов на данное мероприятие');
                return view('attestations.attestation-athletes', ['attestation' => $attestation, 'athletes' => $athletes, 'attestationAthletes' => $attestationAthletes]);
            }
            return view('attestations.attestation-athletes', ['attestation' => $attestation, 'athletes' => $athletes, 'tehkvals' => $tehkvals, 'attestationAthletes' => $attestationAthletes]);
        }

        $athletes = $attestation->athletes()
            ->get()->sortBy(function ($athlete) {
                return $athlete->user->secondname;
            });

        return view('attestations.attestation-athletes', ['attestation' => $attestation, 'athletes' => $athletes, 'tehkvals' => $tehkvals, 'attestationAthletes' => $attestationAthletes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($attestation_id, GetAttestationAthletes $GetattestationAthletes)
    {
        $tehkvals = Tehkval::all();
        $sportkvals = Sportkval::all();
        $organization = Organization::all();
        $coaches = Coach::with('user')->get();
        $attestation = Attestation::find($attestation_id);
        $attestationAthletes = $GetattestationAthletes->getAthletes(auth()->user()->id);

        if ($attestationAthletes && $attestationAthletes->count() >= 1) {
            return view(
                'attestations.addathletes',
                [
                    'tehkvals' => $tehkvals,
                    'sportkvals' => $sportkvals,
                    'organization' => $organization,
                    'coaches' => $coaches,
                    'attestation' => $attestation,
                    'attestationAthletes' => $attestationAthletes,
                    'GetattestationAthletes' => $GetattestationAthletes
                ]
            );
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
        $attestation = Attestation::find($request->attestation_id);
        $payment = new Payment();

        if ($attestation == null) {
            throw new \Exception('Не найдено аттестации');
        }

        if ($attestation->hasAthlete($request->attestation_id, $athlete->id)) {
            session()->flash('error', 'Данный спортсмен уже добавлен на аттестацию');
            return back();
        }

        if (!$payment->isCurrentYearPaymentApproved($athlete->user->id)) {
            session()->flash('error', 'Для прохождения аттестации необходима оплата ежегодного взноса');
            return back();
        }

        $athlete->attestations()->attach($request->attestation_id, ['approve' => Attestation::APPROVE]);

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
    public function destroy(Attestation $attestation, Athlete $athlete)
    {
        $attestation->athletes()->detach($athlete->id);

        session()->flash('status', 'Спортсмен успешно удален с аттестации');

        return redirect()->route('attestation.athletes.index', $attestation);
    }

    public function attestationAthleteExport()
    {
        return Excel::download(new AttestationAthletesExport(), 'attestation-athletes.xlsx');
    }
}

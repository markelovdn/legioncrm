<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttestationRequest;
use App\Models\Attestation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AttestationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userOrganizationsId = User::with('organizations')->find(auth()->id())->organizations->pluck('id')->toArray();
        $attestations = Attestation::whereIn('organization_id', $userOrganizationsId)->orderBy('date', 'DESC')->get();

        return view('attestations.attestations', [
                'attestations'=>$attestations]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $organizations = Auth::user()->getUserOrganizations(auth()->user()->id);

        return view('attestations.addattestation', ['organizations' => $organizations]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAttestationRequest $request)
    {
        $request->validated();

        $attestation = new Attestation();

        $attestation->title = $request->title;
        $attestation->address = $request->address;
        $attestation->date = $request->date;
        $attestation->open = Attestation::STATUS_OPEN;
        $attestation->archive = Attestation::ACTIVE;
        $attestation->organization_id = $request->org_id;

        $attestation->save();
        session()->flash('status', 'Аттестация успешно добавлена');

        return redirect('attestations');

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
        $organizations = Auth::user()->getUserOrganizations(auth()->user()->id);
        $attestation = Attestation::where('id', $id)->first();

        return view('attestations.editattestation', ['organizations' => $organizations, 'attestation' => $attestation]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreAttestationRequest $request, $id)
    {
        $request->validated();

        $event = Attestation::where('id', $id)->first();

        $event->title = $request->title;
        $event->address = $request->address;
        $event->date = $request->date;
        $event->organization_id = $request->org_id;
        $event->open = $request->open ?? Attestation::STATUS_OPEN ;
        $event->archive = $request->archive ?? Attestation::ACTIVE ;

        $event->save();

        session()->flash('status', 'Данные обновленны');

        return redirect('attestations');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $athlete = DB::table('athlete_attestation')->where('attestation_id', $id)->get();
        if (count($athlete) > 0) {
            session()->flash('error', 'Мероприятие не может быть удалено пока в нем есть участники');
            return back();
        }

        Attestation::destroy($id);
        session()->flash('status', 'Аттестация удалена');

        return redirect('attestations');
    }
}

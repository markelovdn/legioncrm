<?php

namespace App\Exports;

use App\Models\Athlete;
use App\Models\Attestation;
use App\Models\Competition;
use App\Models\Competitor;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class AttestationAthletesExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {

        $attestation = Attestation::with('athletes')->where('id', 1)->first();

        return view('exports.attestation-athletes', [
            'attestation' => $attestation
        ]);
    }
}

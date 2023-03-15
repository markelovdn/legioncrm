<?php


namespace App\BusinessProcess;

use App\Models\Athlete;
use Barryvdh\DomPDF\Facade\Pdf;
use http\Client\Curl\User;
use Illuminate\Http\Request;

class PrintAthleteDocument
{
    public function printCscaCard(Request $request)
    {
        $athlete = Athlete::with('user')->find($request->id);
        $pdf = Pdf::loadView('athletes.print.csca-card', compact('athlete', $athlete))->setPaper('A4', 'landscape');
        return $pdf->stream('csa-card.pdf');
    }
}

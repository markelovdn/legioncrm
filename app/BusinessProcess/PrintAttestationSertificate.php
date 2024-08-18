<?php


namespace App\BusinessProcess;


use App\Models\Athlete;
use Barryvdh\DomPDF\Facade\Pdf;
use http\Client\Curl\User;
use Illuminate\Http\Request;

class PrintAttestationSertificate
{

    public function printSertificate(Request $request)
    {
        $athlete = Athlete::with('user')->find($request->id);
        $pdf = Pdf::loadView('attestations.print.sertificate', ['athlete' => $athlete])->setPaper('A4', 'landscape');
        return $pdf->stream('invoice.pdf');

    }

}

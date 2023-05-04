<?php


namespace App\BusinessProcess;

use App\Models\Athlete;
use Barryvdh\DomPDF\Facade\Pdf;
use http\Client\Curl\User;
use Illuminate\Http\Request;

class PrintAthleteDocument
{
    public function test()
    {
        return view('athletes.print.cska-statement-SOG');
    }

    public function printCscaCard(Request $request)
    {
        $athlete = Athlete::with('user', 'birthcertificate', 'parenteds')->find($request->id);
        $pdf = Pdf::loadView('athletes.print.cska-card', compact('athlete', $athlete))->setPaper('A4', 'landscape');
        return $pdf->stream('csa-card.pdf');
    }

    public function printAgreementParented(Request $request)
    {
        $athlete = Athlete::with('user', 'birthcertificate', 'parenteds')->find($request->id);
        $pdf = Pdf::loadView('athletes.print.agreement-parented-attestation-federation', compact('athlete', $athlete))->setPaper('A4', 'portrait');
        return $pdf->stream('agreement-parented_'.$athlete->user->secondname.' '.$athlete->user->firstname.' '.$athlete->user->patronymic.'.pdf');
    }

    public function printCskaStatementSOG(Request $request)
    {
        $athlete = Athlete::with('user', 'birthcertificate', 'parenteds', 'studyplace')->find($request->id);
        $pdf = Pdf::loadView('athletes.print.cska-statement-SOG', compact('athlete', $athlete))->setPaper('A4', 'portrait');
        return $pdf->stream('заявление СОГ '.$athlete->user->secondname.' '.$athlete->user->firstname.' '.$athlete->user->patronymic.'.pdf');
    }

    public function printCskaStatement(Request $request)
    {
        $athlete = Athlete::with('user', 'birthcertificate', 'parenteds')->find($request->id);
        $pdf = Pdf::loadView('athletes.print.cska-statement', compact('athlete', $athlete))->setPaper('A4', 'portrait');
        return $pdf->stream('заявление ЦСКА '.$athlete->user->secondname.' '.$athlete->user->firstname.' '.$athlete->user->patronymic.'.pdf');
    }


}

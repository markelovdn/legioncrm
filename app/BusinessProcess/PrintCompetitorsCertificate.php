<?php


namespace App\BusinessProcess;

use App\Models\Athlete;
use App\Models\Competition;
use App\Models\Competitor;
use Barryvdh\DomPDF\Facade\Pdf;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use morphos\Russian\NounDeclension;
use morphos\Russian\NounPluralization;

class PrintCompetitorsCertificate
{
    public function printCompetitorsCertificate(Request $request)
    {
        $competition = Competition::find($request->competition_id);

        $competition_title = NounDeclension::getCase(Str::of($competition->title)->before(' '), 'предложный');

//        $competitors = $competition->competitors()->get();

//        foreach ($competitors as $competitor) {
//            if($competitor->id == $request->competitor_id) {
//                $competitor_id = $competitor->id;
//            }
//        }

        $competitor = Competitor::with('athlete', 'weightcategory', 'agecategory')->find($request->competitor_id);
        $pdf = Pdf::loadView('competitors.print.competitor-certificate', ['competition_title' => $competition_title],
            compact(['competitor', $competitor,
                     'competition', $competition
            ]))->setPaper('A4', 'portrait');
        return $pdf->stream('competitor-certifecate.pdf');
    }
}

<?php

namespace App\Exports;

use App\Models\Athlete;
use App\Models\Competition;
use App\Models\Competitor;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class CompetitorsExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {

        $competition = Competition::where('id', 4)->first();
        $competitors = $competition->competitors()
            ->with('athlete', 'agecategory', 'weightcategory', 'tehkvalgroup')
            ->orderBy('id', 'DESC')
            ->get();

        return view('exports.competitors', [
            'competitors' => $competitors
        ]);
    }
}

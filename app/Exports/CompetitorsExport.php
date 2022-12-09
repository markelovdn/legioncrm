<?php

namespace App\Exports;

use App\Models\Athlete;
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
//        $a = Competitor::with('athlete')->get();

        return view('exports.competitors', [
//            'competitors' => Competitor::all()
            'competitors' => Competitor::with('athlete')->get()
        ]);
    }
}

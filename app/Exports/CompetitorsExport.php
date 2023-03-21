<?php

namespace App\Exports;

use App\Models\Athlete;
use App\Models\Competition;
use App\Models\Competitor;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;

class CompetitorsExport implements FromView
{

    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $competition = Competition::where('id', Request::route()->parameters)->first();
        $agecategory_id = \Illuminate\Support\Facades\Request::route()->parameter('agecategory_id');
        $tehkvalgroup_id = \Illuminate\Support\Facades\Request::route()->parameter('tehkvalgroup_id');

        $competitors = $competition->competitors()
            ->with('athlete', 'agecategory', 'weightcategory', 'tehkvalgroup')
            ->when($agecategory_id, function ($query, $agecategory_id)
            {
                return $query->where('agecategory_id', $agecategory_id);
            })
            ->when($tehkvalgroup_id, function ($query, $tehkvalgroup_id)
            {
                return $query->where('tehkvalgroup_id', $tehkvalgroup_id);
            })
            ->orderBy('id', 'DESC')
            ->get();

        return view('exports.competitors', [
            'competitors' => $competitors
        ]);
    }

}

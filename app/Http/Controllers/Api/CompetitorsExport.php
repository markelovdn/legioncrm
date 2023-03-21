<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class CompetitorsExport extends Controller
{
    public function competitorsExport($competition_id)
    {
        $competition = Competition::with('competitors')->where('id', $competition_id)->first();
        $result = [];
        $competitors = $competition->competitors()->get();

        foreach ($competitors as $competitor) {

            $agecategory_id[] = $competitor->agecategory_id;
            $tehkvalgroup_id[] = $competitor->tehkvalgroup_id;

        }

        $a = array_unique(array_values($tehkvalgroup_id));

        $tehkvalgroup_id = DB::table('tehkvals_groups')
            ->whereIn('id', $a)->get();

        return $competition;
    }
}

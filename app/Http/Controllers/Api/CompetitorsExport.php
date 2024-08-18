<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AgeCategory;
use App\Models\Competition;
use App\Models\TehkvalGroup;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class CompetitorsExport extends Controller
{
    public function competitorsExport($competition_id)
    {
        $competition = Competition::with('competitors')->where('id', $competition_id)->first();

        return json_encode($competition->agecategories()->with('tehkvalgroup')->get());
    }
}

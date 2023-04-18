<?php


namespace App\DomainService;


use App\Models\Coach;
use App\Models\Competition;
use App\Models\TehkvalGroup;
use App\Models\WeightCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Builder;

class GetTehKvalGroupsCompetition
{
    public function __invoke()
    {
        $competition_id = Request::query('competition_id');
        $agecategory_id = Request::query('agecategory_id');

        if ($agecategory_id && $competition_id) {
            return TehkvalGroup::where('agecategory_id', $agecategory_id)
                ->where('competition_id', $competition_id)->get();
        } else {
            return null;
        }

    }
}

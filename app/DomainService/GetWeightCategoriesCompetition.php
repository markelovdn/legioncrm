<?php


namespace App\DomainService;


use App\Models\Coach;
use App\Models\Competition;
use App\Models\WeightCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Builder;

class GetWeightCategoriesCompetition
{
    public function __invoke()
    {
        $agecategory_id = Request::query('agecategory_id');

        if ($agecategory_id) {
            return WeightCategory::where('agecategory_id', $agecategory_id)->orderBy('gender')->orderBy('title')->get();
        } else {
            return null;
        }

    }
}

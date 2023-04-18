<?php


namespace App\DomainService;


use App\Models\Coach;
use App\Models\Competition;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Builder;

class GetAgeCategoriesCompetition
{
    public function __invoke()
    {
        $competition_id = Request::query('competition_id');

        $competition = Competition::where('id', $competition_id)->first();

        return $competition->agecategories()->get();
    }
}

<?php


namespace App\DomainService;


use App\Models\Coach;
use App\Models\Competition;
use App\Models\Sportkval;
use App\Models\WeightCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Builder;

class GetSportkvals
{
    public function __invoke()
    {
        return json_encode(Sportkval::get());
    }
}

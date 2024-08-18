<?php

namespace App\Filters;

use App\Models\Athlete;
use App\Models\Coach;
use Illuminate\Http\Request;

class AthleteFilter extends QueryFilter {

    public function coach_id($id = null)
    {
        return $this->builder->when($id, function ($query) use ($id) {
            $query->whereRelation('coaches', 'coach_id', $id);
        });
    }

    public function status($status = null){
        return $this->builder->when($status, function($query) use($status){
            $query->where('status', $status);
        });
    }


}

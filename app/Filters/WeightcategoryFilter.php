<?php

namespace App\Filters;

use Illuminate\Http\Request;

class WeightcategoryFilter extends QueryFilter {
    public function agecategory_id($agecategory_id = null){

        return $this->builder
            ->when($agecategory_id, function($query) use ($agecategory_id){
                $query->where('agecategory_id', $agecategory_id);
            });
    }
}

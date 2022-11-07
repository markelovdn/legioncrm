<?php

namespace App\Filters;

use Illuminate\Http\Request;

class WeightFilter extends QueryFilter {
    public function agecategory_id($id = null){

        return $this->builder
            ->when($id, function($query) use ($id){
                $query->where('agecategory_id', $id);
            });
    }
}

<?php

namespace App\Filters;

use Illuminate\Http\Request;

class CompetitorFilter extends QueryFilter {
    public function agecategory_id($agecategory_id = null){

        return $this->builder
            ->when($agecategory_id, function($query) use ($agecategory_id){
            $query->where('agecategory_id', $agecategory_id);
        });
    }

    public function weightcategory_id($weightcategory_id = null){

        return $this->builder
            ->when($weightcategory_id, function($query) use ($weightcategory_id){
                $query->where('weightcategory_id', $weightcategory_id);
            });
    }

    public function tehkvalgroup_id($tehkvalgroup_id = null){

        return $this->builder
            ->when($tehkvalgroup_id, function($query) use ($tehkvalgroup_id){
                $query->where('tehkvalgroup_id', $tehkvalgroup_id);
            });
    }

    public function competition_id($id = null){
        return $this->builder->when($id, function($query) use($id){
            $query->where('competition_id', $id);
        });
    }
}

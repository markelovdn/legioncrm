<?php

namespace App\Filters;

use Illuminate\Http\Request;

class UserFilter extends QueryFilter {

    public function search_field($search_string = ''){
        return $this->builder
            ->when($search_string, function($query) use($search_string){
            $query->where('secondname', 'LIKE', '%'.$search_string.'%');});
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tehkval extends Model
{
    use HasFactory;

    public function hasAthlete ($tehkval_id, $athlete_id)
    {
        $athlete_tehkval = DB::table('athlete_tehkval')->where('tehkval_id', $tehkval_id)->get();

        foreach ($athlete_tehkval as $item) {
            if ($item->athlete_id == $athlete_id)
            {
                return true;
            }

        }

        return false;
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tehkval extends Model
{
    use HasFactory;
    public const NOT = 1;
    public const WHITE = 2;
    public const WHITEYELLOW = 3;
    public const YELLOW = 4;
    public const YELLOWGREN = 5;
    public const GREN = 6;
    public const GRENBLUE = 7;
    public const BLUE = 8;
    public const BLUERED = 9;
    public const RED = 10;
    public const BROWN = 11;
    public const BLACK1 = 12;
    public const BLACK2 = 13;
    public const BLACK3 = 14;
    public const BLACK4 = 15;
    public const BLACK5 = 16;

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

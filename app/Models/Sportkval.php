<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sportkval extends Model
{
    use HasFactory;

    public function competitor()
    {
        return $this->hasOne(Competitor::class);
    }
}
